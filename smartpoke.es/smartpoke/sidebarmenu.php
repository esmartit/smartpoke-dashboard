<?php

	// ini_set('display_errors','On');
	// error_reporting(E_ALL);

  $operator_id = $_SESSION['operator_id'];
  $operator_profile_id = $_SESSION['operator_profile_id'];
  
  include('library/opendb.php');
  
  $sql = "SELECT profile_id, icon, title, file, mop.section, level, category, es, en ".
         "FROM ".$configValues['TBL_RSMENUOPTIONSPROFILES']." AS mop ".
         "JOIN ".$configValues['TBL_RSMENUOPTIONS']." AS mo ON mop.section = mo.section ".
         "WHERE profile_id = $operator_profile_id AND access = 1 ".
         "ORDER BY category, mop.section, level"; 
	
	$sql_options = pg_query($dbConnect, $sql);
  if(!$sql_options) {
     echo pg_last_error($dbConnect);
     exit;
  } 
  
  include('library/closedb.php');

  $access = '';
  $level = '';
  $category = '';  
  $level0 = 0;
  $level1 = 0;
  $level2 = 0;
	$category_0 = '';
	$category_1 = '';
	$category_2 = '';
    

  echo "<!-- sidebar menu -->
        <div id='sidebar-menu' class='main_menu_side hidden-print main_menu'> ";

  while($row = pg_fetch_row($sql_options)) {
      
    $icon = TRIM($row[1]);
    $title = TRIM($row[7]);
    if ($_SESSION['lang'] == 'en') $title = TRIM($row[8]);
    $file = TRIM($row[3]);
    $section = TRIM($row[4]);
    $level = $row[5];
    $category = $row[6];
     
    if ($level == 0) {
      $category_0 = $category;
      if ($level0 == 1) {
        echo "      </ul>
                  </li>
                </ul> 
              </div>";
        $level0 = 0;
        $level1 = 0;
      }
      if (($level0 == 0) && ($category_0 != $category_2)) {
        echo "<div class='menu_section'>
                <h2>".$title."</h2>";
        $level0 = 1;
      }
    } else {
      if ($level == 1) {
        $category_1 = $category;
        if ($level1 == 1) {
          echo "    </ul>
                  </li>
                </ul>";
          $level1 = 0;
          $level2 = 0;    
        } 
        if (($level1 == 0) && ($category_0 == $category_1)) {
          echo "<ul class='nav side-menu'>
                  <li id='".$file."'><a><i class='".$icon."'></i>".$title."<span class='fa fa-chevron-down'></span></a>
                    <ul class='nav child_menu'>";
          $level1 = 1;
        }
      } else {
        if ($level != 9) {
          $category_2 = $category;
          echo "<li id='".$file."'><a href=".$file."><i class='".$icon."'></i>".$title."</a></li>";
        }  
     }
    }
  }
?>
        </ul>
      </li>
    </ul>
  </div>
</div>


