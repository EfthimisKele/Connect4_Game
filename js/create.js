var me={token:null,piece_color:null};
var game_status={};
var board={};
var last_update=new Date().getTime();
var timer=null;

$(function(){
	draw_board();
	fill_board();
    $('#score4_login').click( login_to_game);
	$('#score4_reset').click( reset_board);
	$('#do_move').click( do_move);
	$('#move_div').hide();
	game_status_update();

});

//δημιουργία πίνακα
function draw_board() {
    var t = '<table id="table">';
    for(var i=1;i<7;i++) {
        t +='<tr>';
        for(var j=1;j<8;j++){
            t += '<td class="score_circle" id="circle_' + i + '_' + j + '">' + i + ',' + j + '</td>';
        }
        t+='</tr>';
    }
    t+='</table>';
    $('#game').html(t);
} 

//γέμισε τον πίνακα με τα δεδομένα από το API
function fill_board() {
	$.ajax({url: "score4.php/board/",headers: {"X-Token": me.token}, success: fill_board_by_data });
}

//κάνε reset τον πίνακα από τα δεδομένα από το API
function reset_board() {
	$.ajax({url: "score4.php/board/", headers: {"X-Token": me.token}, method: 'POST',  success: fill_board_by_data });
	$('#move_div').hide();
	$('#game_initializer').show(2000);
}


//κάνε του πίνακα τα td 
function fill_board_by_data(data) {
	for(var i=0; i<data.length;i++){
		var o =data[i];
		var id = '#circle_'+ o.x + '_' + o.y;
		var c = (o.color!=null)?o.color:'';
		if (c=='R'){
			$(id).addClass('score_circle_R').html();
		}else if (c=='Y'){
			$(id).addClass('score_circle_Y').html();
		}else{
			$(id).addClass('score_circle').html();
		}	
	}
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
			headers: {"X-Token": me.token},
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
	clearTimeout(timer);
	$.ajax({url: "score4.php/status/", success: update_status,headers: {"X-Token": me.token} });
}

function update_status(data) {
	last_update=new Date().getTime();
	var game_stat_old = game_status;
	game_status=data[0];
	update_info();
	clearTimeout(timer);
	if(game_status.p_turn==me.piece_color &&  me.piece_color!=null) {
		x=0;
		// do play
		if(game_stat_old.p_turn!=game_status.p_turn) {
			fill_board();
		}
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

function do_move() {
	var s = $('#the_move').val();
	
	var a = s.trim().split(/[ ]+/);
	if(a.length!=2) {
		alert('Must give 2 numbers');
		return;
	}
	$.ajax({url: "score4.php/board/piece/"+a[0]+'/'+a[1], 
			method: 'PUT',
			dataType: "json",
			contentType: 'application/json',
			data: JSON.stringify( {x: a[0], y: a[1]}),
			headers: {"X-Token": me.token},
			success: move_result,
			error: login_error});	
}

function move_result(data){
	game_status_update();
	fill_board_by_data(data);	
}