
<?php
                    if(isset($cliparts))
                    {
                      echo '<ul class="image-grid" data-container="cliparts">';
                      foreach($cliparts as $row)
                      {
                        echo '<li onclick="updateImage(this)" data-image="'.CLIPART_IMAGE_ABS_PATH.$row['clipart_image_name'].'"><image title="'.$row['clipart_client_name'].'" src="'.CLIPART_IMAGE_ABS_PATH.$row['clipart_image_name'].'" </image></li>';
                      }
                      echo "</ul>";
                      
                    }
                    ?>