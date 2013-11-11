<?php
/**
 * @author Chetan Sharma
 * Below Code block will fetch all the allocated seats 
 * then it will arrange the data in array index on room
 */
$seatAllocatedInfo = $this->dataFetch ( $_SESSION ['roomId'] );
$totalRooms = count ( $_SESSION ['roomData'] );

$seatAllocatedInfoData = array ();
for($i = 0; $i < $totalRooms; $i ++) {
	$seatAllocatedInfoData [] = array ();
}

foreach ( $seatAllocatedInfo as $key => $value ) {
	$seatAllocatedInfoData [$value ['room_id']] [] = $value;
}

/**
 * @author Prateek Saini 
 * This function will called for each room 
 * individually @arg1 Data allocated for the 
 * room @arg2 Room structure i.e. total rows and 
 * number of computer in them. Data is broken for ease of access
 */
function createRow($allocatedData, $roomData, $style = '') {

    $totalRows = count($roomData);
    $maxComputer = 0;
    $tempAllocated = array();
    for ($i = 0; $i < $totalRows; $i ++) {
        $tempAllocated [] = array();
        if (isset($roomData [$i])) {
            for ($j = 0; $j < $roomData [$i] ['computer']; $j ++) {
                $tempAllocated [$i] [] = array();
            }
        }
        if ($maxComputer < $roomData[$i]['computer']) {
            $maxComputer = $roomData[$i]['computer'];
        }
    }
    foreach ($allocatedData as $key => $value) {

        $tempAllocated [($value ['row_number'] - 1)] [$value ['computer_id']] = $value;
    }
    $displayData = "";
    if ($roomData[0]['room_id'] == 7) {
        $tempRow = 0;
        for ($i = $maxComputer; $i >= 1; $i--) {
            foreach ($roomData as $key => $value) {
                if ($i > $value['computer']) {
                    continue;
                }
                if ((isset($tempAllocated [$value ['row_number'] - 1][$i - 1]['computer_id'])) && ($tempAllocated [($value ['row_number']) - 1] [$i - 1] ['computer_id'] == ($i - 1))) {
                    $color = constant(strtoupper(str_replace(' ', '', $tempAllocated [($value ['row_number'] - 1)] [$i - 1] ['department'])));
                    $displayData .= '<div style="float:right; background-color:' .
                            $color . '; " id = "' . $roomData[0]['room_id'] .
                            '_' . ($value ['row_number']) .
                            '_' . ($i - 1) . '" class="cols positionTooltip seatDiv ' .
                            $style . '" ><img id="' .
                            $tempAllocated [($value ['row_number']) - 1] [$i - 1]['eid'] .
                            '" class="dragable dragged custom_tooltip context-menu-sub customSetting1" ' .
                            'src="images/green_chair11.png" width = "16px" height = "16px" /></div>';
                } else {
                    $displayData .= '<div style="float:right" class="cols droppable dropped positionTooltip seatDiv ' .
                            $style . '" id="' . $roomData[0]['room_id'] . '_' .
                            ($value ['row_number']) . '_' . ($i - 1) .
                            '"><img src="images/green_seat.jpeg" class="context-menu-sub" /></div>';
                }
                $tempRow++;
            }
            $displayData .= '<br style="clear:both">';
        }
    } else {
        foreach ($roomData as $key => $value) {
            for ($i = 0; $i < $value ['computer']; $i ++) {
                if ((isset($tempAllocated [($value ['row_number'] - 1)] [$i] ['computer_id'])) && 
                        ($tempAllocated [($value ['row_number'] - 1)] [$i] ['computer_id'] == $i)) {
                    $color = constant(strtoupper(str_replace(' ', '', 
                            $tempAllocated [($value ['row_number'] - 1)] [$i] ['department'])));
                    //$color;	
                    $displayData .= '<div id = "' .
                            $roomData[0]['room_id'] . '_' . $value ['row_number'] . '_' .
                            $i . '" class="cols positionTooltip seatDiv ' .
                            $style . '" style="background-color:' . $color .
                            ';"><img id="' . $tempAllocated [($value ['row_number'] - 1)] [$i] ['eid'] .
                            '" class="dragable dragged custom_tooltip context-menu-sub customSetting2"' .
                            ' src="images/green_chair11.png" width = "16px" height = "16px" /></div>';
                } else {

                    $displayData .= '<div class="cols droppable dropped positionTooltip seatDiv ' .
                            $style . '" id="' . $roomData[0]['room_id'] . '_' . $value ['row_number'] . '_' .
                            $i . '"><img src="images/green_seat.jpeg" class="context-menu-sub" /></div>';
                }
            }
            $displayData .= '<br style="clear:both">';
        }
    }
    unset($tempAllocated);
    return $displayData;
}
?>

<!-- Updated By Prateek Saini -->
<div class="mainContainer roundedBorder">
	<div style="border: 1px solid black; height: 30%; width: 100%;">
		<div class="upperLeftContainer roundedBorder">
			<div class="div1 roundedBorder">
				<div class="googol roundedBorder">
					<label class="writing roundedBorder"><?php echo $lang->GOOGOL;?></label>
				</div>
				<div class="srijjan_2 roundedBorder ">
					<a href='#' onclick='roomLink(7)'><div class="roomTitle "><?php echo $lang->SRIJJANII;?></div></a>
					<div class="rotatediv">
                    <?php echo createRow($seatAllocatedInfoData[7],$_SESSION['roomData'][7]); ?>
                    </div>
				</div>
			</div>
			<div class="div2 roundedBorder ">
				<div class="sofa_reception roundedBorder">
					<img alt="" src="images/sofa.jpg"
						style="float: left; height: 50%; width: 30%; margin-top: 6%;">
					<div class="roomTitle"><?php echo $lang->SOFARECEPTION;?></div>
					<img alt="" src="images/reception.jpeg"
						style="height: 80%; width: 45%; float: right;">
				</div>
				<div class="lobby roundedBorder">
					<div class="roomTitle"><?php echo $lang->LOBBY;?></div>
				</div>
				<div class="loby2 roundedBorder">
					<div class="roomTitle"><?php echo $lang->LOBBY;?></div>
				</div>
				<div class="aer roundedBorder">
					<div class="roomTitle"><?php echo $lang->AER;?></div>
					<div class=" "><?php //echo createRow($seatAllocatedInfoData[8],$_SESSION['roomData'][8]); ?></div>
				</div>
				<div class="aqua roundedBorder">
					<div class="roomTitle"><?php echo $lang->AQUA;?></div>
					<div class=" "><?php //echo createRow($seatAllocatedInfoData[9],$_SESSION['roomData'][9]); ?></div>
				</div>
			</div>
		</div>
		<div class="sofachess roundedBorder">
			<img alt="" src="images/chess.jpeg"
				style="height: 20%; width: 100%; float: right; margin-top: 50%;">
			<div
				style="border: 1px solid black; height: 26%; margin-top: 643%; width: 90%; "><a href='#' onclick='roomLink(36)'><?php echo $lang->ENABLINGMANAGER;?></a><?php echo createRow($seatAllocatedInfoData[36],$_SESSION['roomData'][36],'seatDivEM'); ?>
			</div>
			
		</div>
		<div class="room roundedBorder">
			<div class="roomTitle"><?php echo $lang->ROOM;?></div>
		</div>
		<div class="room1 roundedBorder">
			<div class="roomTitle"><?php echo $lang->ROOM;?></div>
		</div>
		<div class="conference roundedBorder">
			<div class="roomTitle"><?php echo $lang->CONFERENCE;?></div>
			<div class=" "><?php //echo createRow($seatAllocatedInfoData[10],$_SESSION['roomData'][10]); ?></div>
		</div>
	</div>
	<div class="div3 roundedBorder">
		<div
			style="float: left; height: 100%; width: 20%; border: 1px solid black;">
			<div class="roundedBorder"
				style="border: 1px solid black; float: left; height: 13%; width: 100%; box-shadow: inset 9px 10px 40px #769DCC;">
				<div class="roomTitle"><?php echo $lang->WASHROOM;?></div>
			</div>
			<div class="roundedBorder"
				style="border: 1px solid black; float: left; height: 4%; width: 100%; box-shadow: inset 9px 10px 40px #DEB887;">
				<div class="roomTitle"><?php echo $lang->LOBBY;?></div>
			</div>
			<div class="roundedBorder"
				style="float: left; height: 24%; width: 100%; border: 1px solid black; box-shadow: inset 9px 10px 40px #F4FFB5;">
				<div class="roomTitle"><?php echo $lang->CAFETERIA;?></div>
			</div>
			<div class="roundedBorder"
				style="float: left; height: 13%; width: 100%; border: 1px solid black; box-shadow: inset 9px 10px 75px #FFF8DC;">
				<a href='#' onclick='roomLink(34)'><div class="roomTitle"><?php echo $lang->ROOM1;?></div></a>
				<div class="  newSmall"><?php echo createRow($seatAllocatedInfoData[34],$_SESSION['roomData'][34]); ?></div>
			</div>
			<div class="roundedBorder"
				style="float: left; height: 13%; width: 100%; border: 1px solid black; box-shadow: inset 9px 10px 75px #FFF8DC;">
				<a href='#' onclick='roomLink(35)'><div class="roomTitle"><?php echo $lang->ROOM2;?></div></a>
				<div class="  newSmall"><?php echo createRow($seatAllocatedInfoData[35],$_SESSION['roomData'][35]); ?></div>
			</div>
			<div class="roundedBorder"
				style="float: left; height: 15%; width: 100%; box-shadow: inset 9px 10px 75px #FFF8DC; border: 1px solid black;">
				<a href='#' onclick='roomLink(20)'><div class="roomTitle"><?php echo $lang->SRIJANI;?></div></a>
				<div class="  newSmall"><?php echo createRow($seatAllocatedInfoData[20],$_SESSION['roomData'][20]); ?></div>
			</div>
			<div class="roundedBorder"
				style="float: left; height: 10%; width: 100%; box-shadow: inset 9px 10px 75px #FFF8DC; border: 1px solid black;">
				<a href='#' onclick='roomLink(19)'><div class="roomTitle"><?php echo $lang->ACCOUNTS;?></div></a>
				<div class=" "><?php echo createRow($seatAllocatedInfoData[19],$_SESSION['roomData'][19]); ?></div>
			</div>
			<div class="roundedBorder"
				style="float: left; height: 6.7%; width: 100%; border: 1px solid black; box-shadow: inset 9px 10px 40px #DEB887;">
				<div class="roomTitle"><?php echo $lang->LOBBY;?></div>
			</div>
		</div>
		<div class="roundedBorder"
			style="letter-spacing: 0.7em; word-wrap: break-word; border: 1px solid black; float: left; height: 100%; width: 4%; box-shadow: inset 9px 10px 40px #DEB887;">
			<div class="roomTitle" style="padding-top: 206px;"><?php echo $lang->LOBBY;?></div>
		</div>
		<div class="roundedBorder"
			style="float: right; width: 75%; border: 1px solid black">
			<div class="room2 roundedBorder" id="meeting">
				<div class="roomTitle"><?php echo $lang->MEETING;?></div>
				<div class=" "><?php //echo createRow($seatAllocatedInfoData[11],$_SESSION['roomData'][11]); ?></div>
			</div>
			<div class="room2 roundedBorder">
				<a href='#' onclick='roomLink(12)'><div class="roomTitle"><?php echo $lang->ROOM3;?></div></a>
				<div class=" "><?php echo createRow($seatAllocatedInfoData[12],$_SESSION['roomData'][12]); ?></div>
			</div>
			<div class="room2 roundedBorder">
				<a href='#' onclick='roomLink(13)'><div class="roomTitle"><?php echo $lang->SACHINKHURANA;?></div></a>
				<div class=" "><?php echo createRow($seatAllocatedInfoData[13],$_SESSION['roomData'][13]); ?></div>
			</div>
			<div class="room2 roundedBorder" id="meeting1">
				<div class="roomTitle"><?php echo $lang->MEETING;?></div>
				<div class=" "><?php //echo createRow($seatAllocatedInfoData[14],$_SESSION['roomData'][14]); ?></div>
			</div>
		</div>
		<div style="float: right; width: 75.4%; height: 88%">
			<div class="roundedBorder"
				style="border: 1px solid black; float: right; height: 100%; width: 11%;">
				<div class="cabin roundedBorder">
					<a href='#' onclick='roomLink(3)'><div class="roomTitle"><?php echo $lang->CABIN1;?></div></a>
					<div class=" "><?php echo createRow($seatAllocatedInfoData[3],$_SESSION['roomData'][3]); ?></div>
				</div>
				<div class="cabin roundedBorder">
					<a href='#' onclick='roomLink(4)'><div class="roomTitle"><?php echo $lang->CABIN2;?></div></a>
					<div class=" "><?php echo createRow($seatAllocatedInfoData[4],$_SESSION['roomData'][4]); ?></div>
				</div>
				<div class="cabin roundedBorder">
					<a href='#' onclick='roomLink(5)'><div class="roomTitle"><?php echo $lang->CABIN3;?></div></a>
					<div class=" "><?php echo createRow($seatAllocatedInfoData[5],$_SESSION['roomData'][5]); ?></div>
				</div>
				<div class="cabin roundedBorder">
					<a href='#' onclick='roomLink(6)'><div class="roomTitle"><?php echo $lang->CABIN4;?></div></a>
					<div class=" "><?php echo createRow($seatAllocatedInfoData[6],$_SESSION['roomData'][6]); ?></div>
				</div>
				<div class="cabin roundedBorder">
					<a href='#' onclick='roomLink(21)'><div class="roomTitle"><?php echo $lang->CABIN5;?></div></a>
					<div class=" "><?php echo createRow($seatAllocatedInfoData[21],$_SESSION['roomData'][21]); ?></div>
				</div>
				<div class="cabin roundedBorder">
					<a href='#' onclick='roomLink(22)'><div class="roomTitle"><?php echo $lang->CABIN6;?></div></a>
					<div class=" "><?php echo createRow($seatAllocatedInfoData[22],$_SESSION['roomData'][22]); ?></div>
				</div>
				<div class="cabin roundedBorder">
					<a href='#' onclick='roomLink(23)'><div class="roomTitle"><?php echo $lang->CABIN7;?></div></a>
					<div class=" "><?php echo createRow($seatAllocatedInfoData[23],$_SESSION['roomData'][23]); ?></div>
				</div>
				<div class="cabin roundedBorder">
					<a href='#' onclick='roomLink(24)'><div class="roomTitle"><?php echo $lang->CABIN8;?></div></a>
					<div class=" "><?php echo createRow($seatAllocatedInfoData[24],$_SESSION['roomData'][24]); ?></div>
				</div>
				<div class="cabin roundedBorder">
					<a href='#' onclick='roomLink(25)'><div class="roomTitle"><?php echo $lang->CABIN9;?></div></a>
					<div class=" "><?php echo createRow($seatAllocatedInfoData[25],$_SESSION['roomData'][25]); ?></div>
				</div>
				<div class="cabin roundedBorder">
					<a href='#' onclick='roomLink(26)'><div class="roomTitle"><?php echo $lang->CABIN10;?></div></a>
					<div class=" "><?php echo createRow($seatAllocatedInfoData[26],$_SESSION['roomData'][26]); ?></div>
				</div>
				<div class="cabin roundedBorder">
					<a href='#' onclick='roomLink(27)'><div class="roomTitle"><?php echo $lang->CABIN11;?></div></a>
					<div class=" "><?php echo createRow($seatAllocatedInfoData[27],$_SESSION['roomData'][27]); ?></div>
				</div>
				<div class="cabin roundedBorder">
					<a href='#' onclick='roomLink(28)'><div class="roomTitle"><?php echo $lang->CABIN12;?></div></a>
					<div class=" "><?php echo createRow($seatAllocatedInfoData[28],$_SESSION['roomData'][28]); ?></div>
				</div>
				<div class="cabin roundedBorder">
					<a href='#' onclick='roomLink(29)'><div class="roomTitle"><?php echo $lang->CABIN13;?></div></a>
					<div class=" "><?php echo createRow($seatAllocatedInfoData[29],$_SESSION['roomData'][29]); ?></div>
				</div>
				<div class="cabin roundedBorder">
					<a href='#' onclick='roomLink(30)'><div class="roomTitle"><?php echo $lang->CABIN14;?></div></a>
					<div class=" "><?php echo createRow($seatAllocatedInfoData[30],$_SESSION['roomData'][30]); ?></div>
				</div>
			</div>
			<div class="lobbySirijan roundedBorder">
				<div class="roomTitle" style="padding-top: 206px;"><?php echo $lang->LOBBY;?></div>
			</div>
			<div class="roundedBorder"
				style="border: 1px solid black; float: right; height: 100%; width: 84.9%; box-shadow: 9px 10px 75px #FFF8DC inset;">
				<div class="roomContent">
				<a href='#' onclick='roomLink(2)'><div class="roomTitle"><?php echo $lang->MAINLAB;?></div></a>
					<div class="mainLab"><?php echo createRow($seatAllocatedInfoData[2],$_SESSION['roomData'][2]); ?></div>

					<div id="cabinrony roundedBorder"
						style="border: 1px solid black; width: 100%; height: 15%; ">
						<div class="roundedBorder"
							style="border: 1px solid black; box-shadow: inset 9px 10px 75px #FFF8DC; width: 20%; height: 75%; margin-top: 1%; float: left; margin-left: 30%;">
							<a href='#' onclick='roomLink(31)'><div class="roomTitle"><?php echo $lang->CHANDERMOHAN;?></div></a>
							<div class=" "><?php echo createRow($seatAllocatedInfoData[31],$_SESSION['roomData'][31]); ?></div>
						</div>
						<div class="roundedBorder"
							style="border: 1px solid black; box-shadow: inset 9px 10px 75px #FFF8DC; width: 20%; height: 75%; margin-top: 1%; float: left; margin-left: 2%;">
							<a href='#' onclick='roomLink(32)'><div class="roomTitle"><?php echo $lang->PRINCE;?></div></a>
							<div class=" "><?php echo createRow($seatAllocatedInfoData[32],$_SESSION['roomData'][32]); ?></div>
						</div>
						<div class="roundedBorder"
							style="border: 1px solid black; box-shadow: inset 9px 10px 75px #FFF8DC; width: 20%; height: 75%; margin-top: 1%; float: left; margin-left: 2%;">
							<a href='#' onclick='roomLink(33)'><div class="roomTitle"><?php echo $lang->RONY;?></div></a>
							<div class=" "><?php echo createRow($seatAllocatedInfoData[33],$_SESSION['roomData'][33]); ?></div>
						</div>
					</div>
					<div class="lobbyBottom">
            
            <?php echo $lang->LOBBY;?>
            </div>
				</div>
			</div>
		</div>
	</div>
	<div class="lastdiv roundedBorder"
		style="float: left; height: 10%; width: 100%; border: 1px solid black;">
		<div class="roundedBorder"
			style="float: left; height: 100%; width: 19.7%; border: 1px solid black; box-shadow: inset 9px 10px 40px #769DCC;">
			<div class="roomTitle"><?php echo $lang->WASHROOM;?></div>
		</div>
		<div style="float: right; width: 80%;">
			<div class="room3 roundedBorder">
				<a href='#' onclick='roomLink(15)'><div class="roomTitle"><?php echo $lang->PRANABJYOTIDAS;?></div></a>
				<div class=" "><?php echo createRow($seatAllocatedInfoData[15],$_SESSION['roomData'][15]); ?></div>
			</div>
			<div class="room3 roundedBorder">
				<a href='#' onclick='roomLink(16)'><div class="roomTitle"><?php echo $lang->ARINDERSINGHSURI;?></div></a>
				<div class=" "><?php echo createRow($seatAllocatedInfoData[16],$_SESSION['roomData'][16]); ?></div>
			</div>
			<div class="room3 roundedBorder">
				<a href='#' onclick='roomLink(17)'><div class="roomTitle"><?php echo $lang->SONALIMINOCHA;?></div></a>
				<div class=" "><?php echo createRow($seatAllocatedInfoData[17],$_SESSION['roomData'][17]); ?></div>
			</div>
			<div class="room3 roundedBorder">
				<a href='#' onclick='roomLink(18)'><div class="roomTitle"><?php echo $lang->SAURABH;?></div></a>
				<div class=" "><?php echo createRow($seatAllocatedInfoData[18],$_SESSION['roomData'][18]); ?></div>
			</div>
		</div>
	</div>
</div>
