"""
eCourts Criminal Records Scraper
Scrapes https://services.ecourts.gov.in for case status by party name.
"""

import time
import logging
from dataclasses import dataclass, field
from typing import Optional

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait, Select
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.options import Options
from selenium.common.exceptions import (
    TimeoutException,
    NoSuchElementException,
    WebDriverException,
)

logging.basicConfig(level=logging.INFO, format="%(levelname)s: %(message)s")
log = logging.getLogger(__name__)

BASE_URL = "https://services.ecourts.gov.in/ecourtindia_v6/"
DEFAULT_WAIT = 10  # seconds


@dataclass
class CourtCase:
    case_number: str
    court: str
    status: str
    filing_date: str
    case_type: str = ""
    petitioner: str = ""
    respondent: str = ""


@dataclass
class SearchResult:
    query_name: str
    query_father_name: str
    query_state: str
    total_cases: int = 0
    cases: list[CourtCase] = field(default_factory=list)
    error: Optional[str] = None

    @property
    def has_criminal_record(self) -> bool:
        return self.total_cases > 0


_CHROME_CANDIDATES = [
    "/opt/pw-browsers/chromium-1194/chrome-linux/chrome",
    "/usr/bin/google-chrome",
    "/usr/bin/chromium",
    "/usr/bin/chromium-browser",
]


def _build_driver(headless: bool = True) -> webdriver.Chrome:
    opts = Options()
    if headless:
        opts.add_argument("--headless=new")
    opts.add_argument("--no-sandbox")
    opts.add_argument("--disable-dev-shm-usage")
    opts.add_argument("--disable-gpu")
    opts.add_argument("--window-size=1920,1080")
    opts.add_argument(
        "user-agent=Mozilla/5.0 (X11; Linux x86_64) "
        "AppleWebKit/537.36 (KHTML, like Gecko) "
        "Chrome/120.0.0.0 Safari/537.36"
    )

    import os
    for candidate in _CHROME_CANDIDATES:
        if os.path.isfile(candidate):
            opts.binary_location = candidate
            log.info("Using Chrome binary: %s", candidate)
            break

    from selenium.webdriver.chrome.service import Service
    service = Service(executable_path="/opt/node22/bin/chromedriver")
    return webdriver.Chrome(service=service, options=opts)


def _parse_case_rows(driver: webdriver.Chrome) -> list[CourtCase]:
    """Extract case data from the results table."""
    cases = []
    wait = WebDriverWait(driver, DEFAULT_WAIT)

    try:
        wait.until(
            EC.presence_of_element_located((By.CLASS_NAME, "case-row"))
        )
    except TimeoutException:
        # No results found — not an error
        return cases

    rows = driver.find_elements(By.CLASS_NAME, "case-row")
    for row in rows:
        def _text(cls: str) -> str:
            try:
                return row.find_element(By.CLASS_NAME, cls).text.strip()
            except NoSuchElementException:
                return ""

        cases.append(
            CourtCase(
                case_number=_text("case-no"),
                court=_text("court-name"),
                status=_text("status"),
                filing_date=_text("date"),
                case_type=_text("case-type"),
                petitioner=_text("petitioner"),
                respondent=_text("respondent"),
            )
        )
    return cases


def check_court_cases(
    driver_name: str,
    father_name: str,
    state: str,
    headless: bool = True,
) -> SearchResult:
    """
    Search eCourts portal for cases linked to a party name.

    Args:
        driver_name:  Full name of the party to search.
        father_name:  Father's name of the party.
        state:        State name (e.g. "Maharashtra").
        headless:     Run Chrome without a visible window.

    Returns:
        SearchResult with all found cases.
    """
    result = SearchResult(
        query_name=driver_name,
        query_father_name=father_name,
        query_state=state,
    )

    driver = None
    try:
        driver = _build_driver(headless=headless)
        wait = WebDriverWait(driver, DEFAULT_WAIT)
        log.info("Opening eCourts portal…")
        driver.get(BASE_URL)

        # Navigate to party-name search tab if present
        try:
            party_tab = wait.until(
                EC.element_to_be_clickable(
                    (By.XPATH, "//a[contains(text(),'Party Name')]")
                )
            )
            party_tab.click()
            time.sleep(1)
        except TimeoutException:
            log.warning("Party Name tab not found — trying default form.")

        # Select state from dropdown
        try:
            state_select = wait.until(
                EC.presence_of_element_located((By.ID, "sess_state_code"))
            )
            Select(state_select).select_by_visible_text(state)
            time.sleep(1)
        except (TimeoutException, NoSuchElementException):
            log.warning("State dropdown not found; skipping state selection.")

        # Wait for district dropdown to populate, then select first district
        try:
            dist_select = wait.until(
                EC.presence_of_element_located((By.ID, "sess_dist_code"))
            )
            options = Select(dist_select).options
            if len(options) > 1:
                Select(dist_select).select_by_index(1)
                time.sleep(1)
        except (TimeoutException, NoSuchElementException):
            log.warning("District dropdown not found; skipping.")

        # Fill party name fields
        name_field = wait.until(
            EC.presence_of_element_located((By.ID, "party_name"))
        )
        name_field.clear()
        name_field.send_keys(driver_name)

        try:
            father_field = driver.find_element(By.ID, "adv_act_no")
            father_field.clear()
            father_field.send_keys(father_name)
        except NoSuchElementException:
            log.warning("Father name field not found; skipping.")

        # Submit
        submit_btn = wait.until(
            EC.element_to_be_clickable((By.ID, "searchPartyName"))
        )
        submit_btn.click()
        log.info("Search submitted. Waiting for results…")
        time.sleep(3)

        cases = _parse_case_rows(driver)
        result.cases = cases
        result.total_cases = len(cases)
        log.info("Found %d case(s).", result.total_cases)

    except WebDriverException as exc:
        result.error = str(exc)
        log.error("WebDriver error: %s", exc)
    finally:
        if driver is not None:
            driver.quit()

    return result


def print_result(result: SearchResult) -> None:
    print(f"\n{'='*60}")
    print(f"Search: {result.query_name} / {result.query_father_name} / {result.query_state}")
    print(f"Total cases found : {result.total_cases}")
    print(f"Has criminal record: {result.has_criminal_record}")
    if result.error:
        print(f"Error             : {result.error}")
    for i, case in enumerate(result.cases, 1):
        print(f"\n  Case {i}:")
        print(f"    Number     : {case.case_number}")
        print(f"    Court      : {case.court}")
        print(f"    Status     : {case.status}")
        print(f"    Filed      : {case.filing_date}")
        if case.petitioner:
            print(f"    Petitioner : {case.petitioner}")
        if case.respondent:
            print(f"    Respondent : {case.respondent}")
    print("="*60)


if __name__ == "__main__":
    result = check_court_cases(
        driver_name="RAJESH KUMAR",
        father_name="RAM KUMAR",
        state="Maharashtra",
    )
    print_result(result)
