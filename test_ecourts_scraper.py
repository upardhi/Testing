"""
Unit tests for ecourts_scraper.py.
These tests mock Selenium so no browser or network is needed.
"""

import pytest
from unittest.mock import MagicMock, patch, PropertyMock

from ecourts_scraper import (
    CourtCase,
    SearchResult,
    _parse_case_rows,
    check_court_cases,
    print_result,
)


# ---------------------------------------------------------------------------
# CourtCase & SearchResult dataclass tests
# ---------------------------------------------------------------------------

class TestCourtCase:
    def test_defaults(self):
        c = CourtCase(case_number="123", court="HC", status="Pending", filing_date="01-01-2024")
        assert c.case_type == ""
        assert c.petitioner == ""
        assert c.respondent == ""

    def test_all_fields(self):
        c = CourtCase(
            case_number="CC/001/2023",
            court="District Court Mumbai",
            status="Disposed",
            filing_date="15-03-2023",
            case_type="Criminal",
            petitioner="State",
            respondent="RAJESH KUMAR",
        )
        assert c.case_number == "CC/001/2023"
        assert c.respondent == "RAJESH KUMAR"


class TestSearchResult:
    def test_has_criminal_record_false_when_empty(self):
        r = SearchResult(query_name="A", query_father_name="B", query_state="C")
        assert r.has_criminal_record is False

    def test_has_criminal_record_true_when_cases_present(self):
        case = CourtCase("1", "Court", "Pending", "01-01-2024")
        r = SearchResult(
            query_name="A", query_father_name="B", query_state="C",
            total_cases=1, cases=[case],
        )
        assert r.has_criminal_record is True

    def test_error_field_defaults_none(self):
        r = SearchResult(query_name="A", query_father_name="B", query_state="C")
        assert r.error is None


# ---------------------------------------------------------------------------
# _parse_case_rows tests
# ---------------------------------------------------------------------------

def _make_row(fields: dict) -> MagicMock:
    """Build a mock 'case-row' element with child elements for each class."""
    row = MagicMock()

    def find_by_class(cls):
        el = MagicMock()
        el.text = fields.get(cls, "")
        return el

    def find_element_side_effect(by, value):
        if by == "class name":
            return find_by_class(value)
        raise Exception(f"Unexpected locator: {by}={value}")

    row.find_element.side_effect = find_element_side_effect
    return row


class TestParseRows:
    def _driver_with_rows(self, rows):
        driver = MagicMock()
        driver.find_elements.return_value = rows
        return driver

    @patch("ecourts_scraper.WebDriverWait")
    def test_empty_results(self, mock_wait):
        # Simulate TimeoutException — no results table
        from selenium.common.exceptions import TimeoutException
        mock_wait.return_value.until.side_effect = TimeoutException()
        driver = MagicMock()
        result = _parse_case_rows(driver)
        assert result == []

    @patch("ecourts_scraper.WebDriverWait")
    def test_single_row(self, mock_wait):
        mock_wait.return_value.until.return_value = MagicMock()
        row = _make_row({
            "case-no": "CC/5/2023",
            "court-name": "Sessions Court",
            "status": "Pending",
            "date": "10-05-2023",
            "case-type": "Criminal",
            "petitioner": "State",
            "respondent": "John Doe",
        })
        driver = self._driver_with_rows([row])
        cases = _parse_case_rows(driver)
        assert len(cases) == 1
        assert cases[0].case_number == "CC/5/2023"
        assert cases[0].court == "Sessions Court"
        assert cases[0].status == "Pending"

    @patch("ecourts_scraper.WebDriverWait")
    def test_multiple_rows(self, mock_wait):
        mock_wait.return_value.until.return_value = MagicMock()
        rows = [
            _make_row({"case-no": f"CC/{i}/2023", "court-name": "HC",
                       "status": "Disposed", "date": "01-01-2023"})
            for i in range(3)
        ]
        driver = self._driver_with_rows(rows)
        cases = _parse_case_rows(driver)
        assert len(cases) == 3

    @patch("ecourts_scraper.WebDriverWait")
    def test_missing_element_returns_empty_string(self, mock_wait):
        from selenium.common.exceptions import NoSuchElementException
        mock_wait.return_value.until.return_value = MagicMock()

        row = MagicMock()
        row.find_element.side_effect = NoSuchElementException()
        driver = self._driver_with_rows([row])
        cases = _parse_case_rows(driver)
        assert len(cases) == 1
        assert cases[0].case_number == ""
        assert cases[0].court == ""


# ---------------------------------------------------------------------------
# check_court_cases integration (fully mocked)
# ---------------------------------------------------------------------------

def _make_driver_mock():
    driver = MagicMock()
    wait_instance = MagicMock()
    # Default: all wait().until() return a clickable element mock
    wait_instance.until.return_value = MagicMock()
    return driver, wait_instance


class TestCheckCourtCases:
    @patch("ecourts_scraper._parse_case_rows", return_value=[])
    @patch("ecourts_scraper.WebDriverWait")
    @patch("ecourts_scraper._build_driver")
    def test_no_cases_found(self, mock_build, mock_wait_cls, mock_parse):
        driver = MagicMock()
        mock_build.return_value = driver
        mock_wait_cls.return_value.until.return_value = MagicMock()

        # Select mock for state/district dropdowns
        with patch("ecourts_scraper.Select") as mock_select_cls:
            sel_instance = MagicMock()
            sel_instance.options = [MagicMock(), MagicMock()]
            mock_select_cls.return_value = sel_instance

            result = check_court_cases("RAJESH KUMAR", "RAM KUMAR", "Maharashtra")

        assert result.total_cases == 0
        assert result.has_criminal_record is False
        assert result.error is None
        driver.quit.assert_called_once()

    @patch("ecourts_scraper._parse_case_rows")
    @patch("ecourts_scraper.WebDriverWait")
    @patch("ecourts_scraper._build_driver")
    def test_cases_found(self, mock_build, mock_wait_cls, mock_parse):
        driver = MagicMock()
        mock_build.return_value = driver
        mock_wait_cls.return_value.until.return_value = MagicMock()

        fake_case = CourtCase("CC/1/2023", "HC Mumbai", "Pending", "01-01-2023")
        mock_parse.return_value = [fake_case]

        with patch("ecourts_scraper.Select") as mock_select_cls:
            sel_instance = MagicMock()
            sel_instance.options = [MagicMock(), MagicMock()]
            mock_select_cls.return_value = sel_instance

            result = check_court_cases("RAJESH KUMAR", "RAM KUMAR", "Maharashtra")

        assert result.total_cases == 1
        assert result.has_criminal_record is True
        assert result.cases[0].case_number == "CC/1/2023"
        driver.quit.assert_called_once()

    @patch("ecourts_scraper._build_driver")
    def test_webdriver_exception_captured(self, mock_build):
        from selenium.common.exceptions import WebDriverException
        mock_build.side_effect = WebDriverException("Chrome not found")

        result = check_court_cases("A", "B", "Maharashtra")

        assert result.error is not None
        assert "Chrome not found" in result.error
        assert result.total_cases == 0

    @patch("ecourts_scraper._parse_case_rows", return_value=[])
    @patch("ecourts_scraper.WebDriverWait")
    @patch("ecourts_scraper._build_driver")
    def test_query_fields_recorded(self, mock_build, mock_wait_cls, mock_parse):
        driver = MagicMock()
        mock_build.return_value = driver
        mock_wait_cls.return_value.until.return_value = MagicMock()

        with patch("ecourts_scraper.Select"):
            result = check_court_cases("NAME", "FATHER", "Delhi")

        assert result.query_name == "NAME"
        assert result.query_father_name == "FATHER"
        assert result.query_state == "Delhi"

    @patch("ecourts_scraper._parse_case_rows", return_value=[])
    @patch("ecourts_scraper.WebDriverWait")
    @patch("ecourts_scraper._build_driver")
    def test_driver_always_quit(self, mock_build, mock_wait_cls, mock_parse):
        """Ensure driver.quit() is called even when an exception is raised mid-search."""
        from selenium.common.exceptions import TimeoutException
        driver = MagicMock()
        mock_build.return_value = driver
        mock_wait_cls.return_value.until.side_effect = TimeoutException("timeout")

        result = check_court_cases("A", "B", "Maharashtra")
        driver.quit.assert_called_once()


# ---------------------------------------------------------------------------
# print_result smoke test
# ---------------------------------------------------------------------------

class TestPrintResult:
    def test_prints_without_error(self, capsys):
        case = CourtCase(
            case_number="CC/10/2024",
            court="District Court",
            status="Pending",
            filing_date="01-01-2024",
            petitioner="State",
            respondent="Doe",
        )
        result = SearchResult(
            query_name="Doe",
            query_father_name="John Sr",
            query_state="Maharashtra",
            total_cases=1,
            cases=[case],
        )
        print_result(result)
        captured = capsys.readouterr()
        assert "CC/10/2024" in captured.out
        assert "District Court" in captured.out
        assert "Pending" in captured.out

    def test_prints_error_field(self, capsys):
        result = SearchResult(
            query_name="X", query_father_name="Y", query_state="Z",
            error="Connection refused"
        )
        print_result(result)
        captured = capsys.readouterr()
        assert "Connection refused" in captured.out
