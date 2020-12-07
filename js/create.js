var me={};
var game_status={};


$(function(){
     draw_board();
});


function draw_board() {
    var t = '<table id="table">';
    for(var i=1;i<7;i++) {
        t +='<tr>';
        for(var j=1;j<8;j++){
            t += '<td class="score_circle" id="circle_' + i+ '_' + j + '">' + i + ',' + j + '</td>';
        }
        t+='</tr>';
    }
    t+='</table>';
    $('#game').html(t);
} 

function reset_board() {
	$.ajax({url: "chess.php/board/", method: 'POST',  success: fill_board_by_data });
	$('#move_div').hide();
	$('#game_initializer').show(2000);
}