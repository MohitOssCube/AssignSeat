<h3><u><?php echo $lang->DEPARTMENTCOLOR; ?></u></h3>
<table cellpadding="5" cellspacing="5">
    <?php
    $fileName = getcwd();
    $fileName .= "/libraries/departmentColorConstant.php";
    $searchfor = strtoupper('"#');
    $contents = file_get_contents($fileName);
    $pattern = preg_quote($searchfor, '/');
    $pattern = "/^.*$pattern.*\$/m";
    if (preg_match_all($pattern, $contents, $matches)) {
        for ($i = 0; $i < count($matches[0]); $i ++) {
            $arr = array();
            $actualValue = $matches[0][$i];
            $matches[0][$i] = str_replace("define (", "", $matches[0][$i]);
            $matches[0][$i] = str_replace(");", "", $matches[0][$i]);
            $matches[0][$i] = str_replace("'", "", $matches[0][$i]);
            $matches[0][$i] = str_replace('"', '', $matches[0][$i]);
            $arr[] = explode(",", $matches[0][$i]);
            $deptName=ucwords(strtolower($arr[0][0]));
            ?>
            <tr>
                <td>
        <?php if($deptName === 'Humancapitalmanagement'):
            echo 'HCM';
          elseif($deptName === 'Businessdevelopment'):
              echo 'BD';
          else:
              echo $deptName;
          endif;
              ?>
                </td>
                <td >
                    <div style="height:15px;width:15px; align:center;background-color:<?php echo $arr[0][1]; ?>"></div>
                </td>
            </tr>
        <?php
    }
}
?>
</table>
