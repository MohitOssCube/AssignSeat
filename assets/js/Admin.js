/**
 * This file have function related to Admin.
 */
function getUsersPanal()
{
    $.post('index.php?controller=MainController&method=getUsersView', function(data) {
        if (data.indexOf('Reset') !== -1)
        {
            location.reload();
        }
        $('#adminPanal').html(data);
    })
}

$(function() {
    getData();
});

function showRoomDetails(id) {
    $.post('index.php?controller=MainController&method=getRoomDetails',
            {
                'roomId': id
            },
    function(data) {
        if (data.search('roomDetail') !== -1)
        {
            $("#adminPanal").html(data);
        }
        else
        {
            location.reload();
        }

    }
    );

}

function logMeOut() {
    $.post('index.php?controller=MainController&method=logout', function(data, status) {
        window.location.href = 'index.php';
    });
}

function uploadcsv() {
    $.post('index.php?controller=MainController&method=loadUploadView',
            {
            },
            function(data) {
                $("#adminPanal").html(data);
            });
}

function deptcolor()
{
    $.ajax
            ({
                type: "POST",
                url: 'index.php?controller=MainController&method=deptColor',
                success: function(data)
                {
                    $("#adminPanal").html(data);
                }

            });
}


function addNewRow(roomId, rowCount)
{
    $("#addRowButton").remove();
    selectButton = "<select id='newSelectRow'>";
    for (i = 1; i <= 20; i++)
    {
        selectButton += "<option ";
        selectButton += " value=" + i + ">" + i + " Computer</option>";
    }
    selectButton += "</select> ";
    saveButton = "<input type='button' value='Save' onclick=saveNewRow(" + roomId + "," + (rowCount + 1) + ")>";
    $("#newRowEntry").html('<label id="newRowCount">Row ' + (rowCount + 1) + '<label> ' + selectButton + saveButton);
    $("#newRowEntry").show();
}
function saveNewRow(roomId, rowCount)
{
    computer = $("#newSelectRow").val();
    roomName = $('#roomName').html();
    /*
     *
     *add to database
     */
    $.post('index.php?controller=MainController&method=addNewRoomRow',
            {'roomId': roomId, 'rowNo': rowCount, 'computer': computer, 'roomName': roomName}, function(data) {
        if (data.indexOf('password') != -1)
        {
            location.reload();
        }
        alert(data);
    });

    showRoomDetails(roomId);
}
function DeleteRow(rowId, roomId)
{
    roomName = $('#roomName').html();
    chk = confirm("Are You Sure");
    if (chk)
    {
        $("#roomRow" + rowId).remove();
        /*
         *Data base entry here
         */
        $.post('index.php?controller=MainController&method=delRoomRow',
                {'roomId': roomId, 'rowId': rowId, 'roomName': roomName}, function(data) {
            if (data.indexOf('password') != -1)
            {
                location.reload();
            }
            alert(data);
        });
        showRoomDetails(roomId);
    }
}
function editComputer(rowId)
{
    computer = $("#row" + rowId).html();
    //alert(computer);
    selectButton = "<select id='selectRow" + rowId + "' onChange='submitComputerChange(" + rowId + ")'>";
    for (i = 1; i <= 20; i++)
    {
        selectButton += "<option ";
        if (computer.trim() == i)
        {
            selectButton += "selected";
        }
        selectButton += " value=" + i + ">" + i + " Computer</option>";
    }
    selectButton += "</select>";
    $("#row" + rowId).html(selectButton);

}
function submitComputerChange(rowId)
{
    computer = $("#selectRow" + rowId).val();
    roomName = $('#roomName').html();
    /*
     *change in database
     */
    $.post('index.php?controller=MainController&method=computerUpdate',
            {'computer': computer, 'rowId': rowId}, function(data) {
        if (data.indexOf('password') != -1)
        {
            location.reload();
        }
        alert(data);
    });
    $("#row" + rowId).html(computer);
}