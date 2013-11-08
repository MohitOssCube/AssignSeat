/**
 * Main  Building java script file.
 * It have all drag drop, context menu and fancy box functions
 */

$changeComment = '';
$tooltipFlag = 1;
draggedElement = "";
moveid = "";
thisid= "";
var didConfirm = false;
var stickDivTopMargin=0;
var windowPosition=265;
$(function(){
	getData();
	startTooltip();// -- this will be enabled after seat drag testing
	startContextMenu();	
	$("#roomFillDetails").fancybox({	    
	    closeClick : false, // prevents closing when clicking INSIDE fancybox
        beforeLoad : function() {
            roomId=$("#hiddenRoomId").val();
            $.post('index.php?controller=MainController&method=roomGraph',{
				roomId:roomId
                },function(data){
        			if(data.indexOf('password') != -1)
        			{
        				location.reload();
        			}
       			$("#roomDetailDiv").html(data);
                    });
           
            return;
        },
	    helpers : {
	    overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
	    },
	    minWidth: '600',
	    minHeight: '550'	    	    
	    });
	    
		$("#report").fancybox({	    
		    closeClick : false, // prevents closing when clicking INSIDE fancybox
		    beforeLoad : function() {
	            $.post('index.php?controller=MainController&method=reportFetch',
	    	            function(data){
	        			if(data.indexOf('Reset') != -1)
	        			{
	        				location.reload();
	        			}
	        			$("#reportData").html(data);
	                    });
	           
	            return;			    
		    
		    },
		    helpers : {
		    overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
		    },
		    minWidth: '1024',
		    minHeight: '580'		      	    
		    });	    
    
$("#logout").click(function(){
	$.post('index.php?controller=MainController&method=logout',function(data,status){
				window.location.href = 'index.php';
				});		
});
 $("#changeComment").on("keyup",function(){
	commentStr=$("#changeComment").val();

    $("#commentCount").html('Word Count: '+commentStr.length);        
    });
});
function showLog()
{
    displayData = '';
    
	$.ajax({
		async : false,
		url : 'index.php?controller=MainController&method=fetchLogData',
		type :'post',
		data : '',
		dataType : "json",
		success : function (data) {
			//alert(data);
		    displayData = '';
		    if(data != "No Data in log file"){
    			$.each(data,function(i,value){
    				displayData += value;
    				displayData += "<br/>";
    				});
    			$("#logData").html('');
    			$("#logData").append(displayData);
		    }
		    else {
    			$("#logData").html('');
    			$("#logData").append(data);		        
		    }
		}
	});
	$("#logOverlayLink").fancybox({	    
	    closeClick : false, // prevents closing when clicking INSIDE fancybox
	    helpers : {
	    overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
	    }
	    });
	$("#logOverlayLink").attr("href","#logData");
	$("#logOverlayLink").trigger("click");
}
function dragdropevent() {
    /**
     * we set the dragable class to be dragable, we add the containment which
     * will be #boxdemo, so dropable and dragable object cant pass out of this
     * box 
     *
     */
    $(".dragable").draggable({
        revert : true,
        helper: "clone",
        cursor: "move", 
        cursorAt: { top: 3, left: 3 },
	scroll: true, 
	scrollSensitivity: 100,
        start : function(event, ui) {
            draggedElement = this.id;
            moveid = $(this).parent('div').attr('id');
		
           
            dragdropevent();
        },
	
    });
    $( ".droppable" ).droppable({
        /**
         * tolerance:fit means, the moveable
         * object has to be inside the dropable
         * object area *
         */
        tolerance : 'intersect',
	
        over : function(event, ui) {
            thisid = this.id;
            /**
             * We add the hoverClass when the moveable object is
             * inside of the dropable object *
             */
            $('.ui-draggable-dragging').addClass('hoverClass');
        },
        out : function(event, ui) {
            prevthisid = this.id;
            /**
             * We remove the hoverClass when the moveable object
             * is outside of the dropable object area *
             */
            $('.ui-draggable-dragging').removeClass(
                    'hoverClass');
            $('#' + prevthisid).removeClass('dropClass');
        },
        /**
         * This is the drop event, when the dragable object is
         * moved on the top of the dropable object area *
         */
        drop : function(event, ui) {
            // alert(thisid);if(thisid=='trash'){
            // alert('haan');
            // }
		//alert(thisid);
           // $(".positionTooltip").tooltip("close");
            $("#changeCommentLink").fancybox({
                closeBtn : true,
                afterLoad : function() {
                    $("#changeComment").val('');
                    return;
                },
                closeClick : false, // prevents closing when
                                    // clicking INSIDE fancybox
                helpers : {
                    overlay : {
                        closeClick : false
                    }
                // prevents closing when clicking OUTSIDE
                // fancybox
                }
            });
    if (thisid == 'trash') {       	
	didConfirm = confirm("Are you sure you want to delete??");
	}
	else {
	$.ajax({
        url : 'index.php?controller=MainController&method=isAssignedSeat',
        type : 'post',
        dataType : 'html',
		async : false,
		data: { employee : draggedElement },
		
        success : function(data){
		//alert(data);
	   if(data.trim()=="1") {
			didConfirm = confirm("Are you sure you want to allocate");
        	}
    			
    		else {
    				//change chair icon to green here
    		didConfirm = confirm("Are you sure u want to reallocate");
    			}
            }
      
        });
	}
	$tooltipFlag = 0;

     if (didConfirm == true) 
	{	
		$("#changeCommentLink").trigger("click"); 
	}
	else
	{
		reLoadMainBuilding();
	}
	
        }
    });
}
function closeFancyBox() {
    $changeComment = $("#changeComment").val();
    $.fancybox.close();
    $("#commentError").html("");

    if (thisid == 'trash') {               
		removeSeat(moveid, $changeComment, draggedElement);
    } else {

        $.post('index.php?controller=MainController&method=assignSeat', {
            roomid : thisid,
	    move :moveid,
            changeComment : $changeComment,
            employee : draggedElement
        }, function(data, status) {
		if(data.indexOf('password') != -1)
			{
				location.reload();
			}
        	if(data.trim()=="1") {
        		alert("Your seat has been booked");
        		reLoadMainBuilding();
        		$("#commentError").html("");
    			}
    			else if(data.trim()=="2") {
    			alert("Your seat has been been reallocated");
    			reLoadMainBuilding();
    			$("#commentError").html("");
    			}else {
    				//change chair icon to green here
    			$("#commentError").html("");
                $("#commentError").html(data);
                $("#changeCommentLink").trigger("click");
    			}
        });
	if (thisid == 'trash') 
	{
		
        }
	else
	{
		$('#' + thisid).droppable('disable')
		$("#" + thisid)
		        .html(
		                '<img src="images/green_chair11.png" id='
		                        + draggedElement
		                        + ' height="16" width="16" class="dragable dragged" />');
		$("#" + moveid).html(' ');
		if (moveid.indexOf("emp") == -1) {
		    $("#" + moveid)
		            .html(
		                    '<img src="images/green_seat.jpeg" />');
		    $("#" + moveid).addClass('droppable ui-droppable dropped');
		}
		dragdropevent();
	}
    }
}
function removeSeat(moveid, $changeComment, draggedElement) {
    $.post('index.php?controller=MainController&method=trashSeat', {
                
				seatid: moveid,
				changeComment : $changeComment,
				employee : draggedElement
           }, function(data, status) {
   			if(data.indexOf('password') != -1)
   			{
   				location.reload();
   			}		
           	if(data.trim()=="1") {
           		alert("Seat has been trashed");
           		reLoadMainBuilding();
           		$("#commentError").html("");
       			}else {
       			$("#commentError").html("");
       			$("#commentError").html(data);
                   $("#changeCommentLink").trigger("click");
       			}
               //window.location.href = 'index.php';
           });
}
function reLoadMainBuilding() {
    location.reload();
}

function startTooltip(){
    /*
    This tooltip will display the user details from database
    after user click on the allocated Seat.
    */
    $('.custom_tooltip').tooltipster({
        timer: 6000,
        trigger: 'click',
        content: 'Loading...',
        functionBefore: function(origin, continueTooltip) {
        
           // we'll make this function asynchronous and allow the 
            //tooltip to go ahead and show the loading notification while fetching our data
           continueTooltip();
             
           // next, we want to check if our data has already been cached
           if (origin.data('ajax') !== 'cached') {
    			displayData = "";
    			$id = $(origin).attr("id");
    			if($id > 0 && $id != '') {
        			$.ajax({
        				async : false,
        				url : 'index.php?controller=MainController&method=fetchUserProfile',
        				type :'post',
        				data : 'eid='+$id,
        				dataType : "json",
        				success : function (data) {
        				    displayData = '';				    
    	                        displayData += "<img src=\""+data['uri']+"\" alt =\"User Image\" width='100px'/>";
    	                        displayData += "<br/>";
        				        displayData += "<label>Name : </label>";
            					displayData += data['name'];
            					displayData += "<br/>";
            					displayData += "<label>Designation : </label>";
            					displayData += data['designation'];
            					displayData += "<br/>";
            					displayData += "<label>Details : </label>";
            					displayData += data['details'];
            				}
        			});
        			origin.tooltipster('update', displayData).data('ajax', 'cached');
    			}
           }
        }
     })
     .on( "mouseover", function(){
    	  	if($tooltipFlag == 1){
    	  	      $( this ).tooltipster( "hide" );
    		  	}
    	    return false;
	  })
	  .on( "drag", function(){
	      $( this ).tooltipster( "hide" );
	  })
     .attr( "title", "" ).css({ cursor: "pointer" });

    /** 
     * This tooltip will display the Room name,
     * Row Number and Column Number for any Seat.
     */
    
    $('.positionTooltip').tooltipster({
        delay: 300,
        timer: 6000,
        content: 'Loading...',
        functionBefore: function(origin, continueTooltip) {
        
           // we'll make this function asynchronous and allow the tooltip to go ahead and show the loading notification while fetching our data
           continueTooltip();             
           // next, we want to check if our data has already been cached
  			displayData = "";
			$id = $(origin).attr("id");
			$roomName = $(origin).parent().prev().html();
			$rowNumber = $id.substring($id.indexOf("_")+1,$id.lastIndexOf("_"));
			$computer = $id.substring($id.lastIndexOf("_")+1);
			displayData = "Room Name: "+$roomName+
    		"<br>"+"Row Number: "+$rowNumber+
    	    "<br>"+"Computer Number: "+(parseInt($computer)+1);
    	    
    		origin.tooltipster('update', displayData);
        }
     })
     .on( "drag", function(){
	  })
     .attr( "title", "" ).css({ cursor: "pointer" });
}

function clearVariables()
{
    draggedElement = "";
    moveid = "";
    thisid= "";
}

function openCommentBox() {
	$("#changeCommentLink").fancybox({
	    closeBtn : false,
	    afterLoad : function() {
	        $("#changeComment").val('');
	        return;
	    },
	    closeClick : false, // prevents closing when
	                        // clicking INSIDE fancybox
	    helpers : {
	        overlay : {
	            closeClick : false
	    }
	    // prevents closing when clicking OUTSIDE
	    // fancybox
	    }
	});
	$("#changeCommentLink").trigger("click");
}


function startContextMenu() {

	    $.contextMenu({
	        selector: '.context-menu-sub', 
	        callback: function(key, options) {

		        switch(key) 
		        {
		        case "pick" : 
			        {
    		            clearVariables();
    			            if($(this).attr("id") > 0 ) {	
    			            draggedElement = $(this).attr("id");
    			            moveid = $(this).parent('div').attr('id');
    			        }
    			        else {
    				        alert("No Employee is allocated to this seat");
    			        }
		            }
			        break;
		        case "drop" : 
		        {
		            if($(this).attr("id") > 0 ) {
		                alert("Seat is already allocated");
		                return;
		            }
			        if(draggedElement != "" && moveid != ""  ) {
				        
			            thisid = $(this).parent().attr("id");
			            openCommentBox();
			            
			        }
			        else {
			            if($(this).attr("id") > 0 ) {
			                alert("Seat is already allocated");
			                return;
			            }
				        alert("No Employee is Selected");
			        }
	            }
		        break;
		        case 'remove': 
		        {
		        	clearVariables();
			        if($(this).attr("id") > 0 ) {	
			            draggedElement = $(this).attr("id");
			            moveid = $(this).parent('div').attr('id');
			            thisid = "trash";
			            openCommentBox();
			        } else {
				        alert("No Employee is allocated to this seat");
			        }
		        }
		        break;
		        case 'history' :
		        {
			        alert("No code is written!!! Work in progress :-)");
		        }
		        }
	        },
	        items: {
	            "drop": {"name": "Drop", "icon": "paste"},
	            "pick": {"name": "Pick", "icon": "cut"},
	            "remove": {"name": "Remove", "icon": "page_white_delete"},	            
	            "sep1": "---------",
	            "history": {"name": "History", "icon": "quit"},
	            "sep2": "---------",
	        }
	    });
}
function roomLink(roomId)
{
	$("#hiddenRoomId").val(roomId);
	$("#roomFillDetails").trigger("click"); 
}
