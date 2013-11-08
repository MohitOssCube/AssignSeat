<center><h2>Room Details</h2></center>

<div id="roomDetail">
<table>
	<tr>
		<td>Room Name : </td>
		<td id='roomName'><?php echo $data[0]['name'];?></td>
	</tr>
		<tr>
		<td>Total Rows : </td>
		<td><?php echo (isset($data[0]['row_number'])) ? count($data) :  '0' ;?></td>
		<td id='addRowButton'><input  type="button" value="Add Row" onClick='addNewRow(<?php echo $data[0]['id']?>,<?php echo (isset($data[0]['row_number'])) ? count($data) :  '0' ;?>)'>
	</tr>
</table>
<div id='newRowEntry' style='display:none'>

</div>
<table id='roomRowTable'>
 <tr>
 	<td>Row No.</td>
 	<td>Total Computer</td>
 </tr>
<?php 
$row=0;
if(isset($data[0]['row_number'])) {
foreach ($data as $key=>$val) {
	$row++;
?>
 <tr id="roomRow<?php  echo $val['row_id']?>">
 	<td>Row <?php echo $row?></td>
 	<td ><div id="row<?php  echo $val['row_id']?>"><?php echo $val['computer']?></div></td>
 	<td onclick='editComputer(<?php echo $val['row_id']?>)' class='editComputer'>Edit</td>
 	<td onclick='DeleteRow(<?php echo $val['row_id']?>,<?php echo $val['id']?>)' class='editComputer'>Delete</td>
 </tr>
<?php 
  }
}
?>
</table>
</div>
