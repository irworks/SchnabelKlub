/* IR Works Narc. Software 

	All rights reserved.
	Copyright 2015, IR Works Narc.
	
	This file is part of the IR Works SchnabelKlub Software,
	DO NOT copy, modify, redistribute, self-host the product or parts of it.
	
	THIS SOFTWARE IS PROVIDED BY IR Works Narc. ''AS IS'' AND ANY
	EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
	WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
	DISCLAIMED. IN NO EVENT SHALL IR Works Narc. BE LIABLE FOR ANY
	DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
	(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
	LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
	ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
	(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
	SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
	
	http://irworks.de
	
*/


$( document ).ready(function() {
	setAdminClickHandlers();
});


function setAdminClickHandlers() {
	$( ".accept-quest" ).on("click", function() {
		approveQuest($(this).attr('data-id'));
    });
    
    $( ".pre-delete-quest" ).on("click", function() {
		var id = $(this).attr('data-id');
		$("#pre-delete-quest_" + id).fadeOut(function() {
			$("#real-delete-quest_" + id).fadeIn();
		});
    });
    
    $( ".real-delete-quest" ).on("click", function() {
		denyQuest($(this).attr('data-id'));
    });
    
}

function approveQuest(questLogID) {

	var score = $("#quest-score_"  + questLogID).html();
	var user  = $("#quest-userid_" + questLogID).html(); 
	
	$("#accept-quest_" + questLogID).html('Speichere Quest - bite warten...');

	$.post( "./ajax/approveQuest", {questID:questLogID, questScore:score, userID:user}, function( data ) {
		data = jQuery.parseJSON(data);
	  
		if(data.error) {
			$("#quest-error_" + questLogID).html('Es ist ein Fehler aufgetreten... :c')
		}else{
			$("#quest-box_"+ questLogID).fadeOut();
		}
			  
	 });
	
}

function denyQuest(questLogID) {

	var user  = $("#quest-userid_" + questLogID).html();

	$.post( "./ajax/denyQuest", {questID:questLogID, userID:user}, function( data ) {
		data = jQuery.parseJSON(data);
	  
		if(data.error) {
			$("#quest-error_" + questLogID).html('Es ist ein Fehler aufgetreten... :c')
		}else{
			$("#quest-box_"+ questLogID).fadeOut();
		}
			  
	 });
	
}
