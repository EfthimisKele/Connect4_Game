var me={};
var game_status={};


$(function(){
    draw_board();

    $('#chess_login').click( login_to_game);
    $('#chess_reset').click( reset_board);
	$('#move_div').hide();
	game_status_update();

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

function fill_board() {
	$.ajax({url: "score4.php/board/", success: fill_board_by_data });
}

function reset_board() {
	$.ajax({url: "score4.php/board/", method: 'POST',  success: fill_board_by_data });
	$('#move_div').hide();
	$('#game_initializer').show(2000);
}

function fill_board_by_data(data) {
	draw_board();
}


function login_to_game() {
	if($('#username').val()=='') {
		alert('You have to set a username');
		return;
	}
	var p_color = $('#pcolor').val();
	draw_board();
	fill_board();
	
	$.ajax({url: "score4.php/players/"+p_color, 
			method: 'PUT',
			dataType: "json",
			contentType: 'application/json',
			data: JSON.stringify( {username: $('#username').val(), piece_color: p_color}),
			success: login_result,
			error: login_error});
}

function login_result(data) {
	me = data[0];
	$('#game_initializer').hide();
	update_info();
	game_status_update();
}

function login_error(data,y,z,c) {
	var x = data.responseJSON;
	alert(x.errormesg);
}


function game_status_update() {
	$.ajax({url: "score4.php/status/", success: update_status });
}

function update_status(data) {
	game_status=data[0];
	update_info();
	if(game_status.p_turn==me.piece_color &&  me.piece_color!=null) {
		x=0;
		// do play
		$('#move_div').show(1000);
		setTimeout(function() { game_status_update();}, 15000);
	} else {
		// must wait for something
		$('#move_div').hide(1000);
		setTimeout(function() { game_status_update();}, 4000);
	}
 	
}

function update_info(){
	$('#game_info').html("I am Player: "+me.piece_color+", my name is "+me.username +'<br>Token='+me.token+'<br>Game state: '+game_status.status+', '+ game_status.p_turn+' must play now.');
	
}

function move_result(data){
	
}