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

var menuOpen = false;
var tweetIsQuest = false;

$(document).ready(function () {

    if ($("#tweetToQuestEnabled" + name).length > 0) {
        //alert("This button is a Quest!");
        tweetIsQuest = true;
    }

    checkActiveTab();

    $('#logo').click(function () {
        window.location.replace('/');
    });

    $(".tweet-window").hide();
    $(".alert").hide();
    $("#nav-pages-mobile").slideUp(1);

    setClickHandlers();

});

function setClickHandlers() {

    $("#mobileMenu").on("click", function () {
        if (menuOpen) {
            $("#nav-pages-mobile").slideUp(200);
        } else {
            $("#nav-pages-mobile").slideDown(200);
        }
        menuOpen = !menuOpen;
    });

    $("#new-tweet").on("click", function () {
        presentTweetDialogWithText("LeL");
    });

    $("#new-entry").on("click", function () {
        $("#new-entry").fadeOut();
        $("#new-entry-text").fadeOut();
        submitQuestWithURL($("#new-entry-text").val());
    });

    $("#withdraw-entry").on("click", function () {
        $("#withdraw-entry").attr('disabled', 'disabled');
        $("#withdraw-entry").html('Ziehe Quest zurück...');
        withdrawQuest();
    });

    $("#close-tweet-dialog").on("click", function () {
        $("#tweetTextField").val('');
        $("#popup_overlayhandler").fadeOut(300);
        $("#submit-tweet-dialog").html('Losschnabeln');
    });

    $("#submit-tweet-dialog").on("click", function () {
        $("#submit-tweet-dialog").html('Sende Tweet an die API...');
        sendTweet($("#tweetTextField").val());
    });
}

function sendTweet(status) {
    $.post("./ajax/sendTweetHandler", {
        message: status
    }, function (data) {

        data = jQuery.parseJSON(data);

        console.log(data);

        var twErrors = false;

        if (typeof data.callback.errors != 'undefined') {
            twErrors = true;
        }

        if (!data.error && !twErrors) {
            $("#popup_overlayhandler").fadeOut(300);
            $("#tweetTextField").val('');
            $("#submit-tweet-dialog").html('Losschnabeln');

            $("#tweet-cont").html(status + ' ');

            if (tweetIsQuest) {
                $("#tweetToQuestEnabled").html('Dein Tweet wurde erfolgreich gesendet, speichere deine Quest zur Prüfung...');
                $("#new-tweet").fadeOut();
                submitQuestWithTwitterStatus('https://twitter.com/acc/status/' + data.callback.id_str);
            }

            if (status.toLowerCase().indexOf("schnabeltier") >= 0) {
                $("#schnabel-check").html('Dein letzter Tweet ist <b>super</b>! <3');
                $("#new-tweet").hide();
            } else {
                $("#schnabel-check").html('Dein letzter Tweet enthält <b>kein</b> Schnabeltier. :(');
                $("#new-tweet").show();
            }

        } else if (twErrors) {
            $("#submit-tweet-dialog").html('Fehler: ' + data.callback.errors[0].message);
        } else {
            //ERROR
            $("#newerrorfield").html(data.errorStr);
            $("#submit-tweet-dialog").html('Fehler: ' + data.errorStr);
        }
    });
}

function submitQuestWithTwitterStatus(url) {

    $.post("./ajax/submitNewQuest", {
        twitterURL: url
    }, function (data) {
        data = jQuery.parseJSON(data);

        if (!data.error) {
            $("#tweetToQuestEnabled").html('Deine Quest wurde gespeichert und wird nun geprüft.');
        } else {
            $("#tweetToQuestEnabled").html('Es ist ein Fehler beim Speichern aufgetreten. :c Kontaktiere uns doch bitte!');
            $("#new-tweet").fadeIn();
        }

    });

}

function submitQuestWithURL(url) {

    $("#linkToQuestEnabled").html('Deine Quest wird gespeichert, bitte warten...');

    $.post("./ajax/submitNewQuest", {
        twitterURL: url
    }, function (data) {
        data = jQuery.parseJSON(data);

        if (!data.error) {
            $("#linkToQuestEnabled").html('Deine Quest wurde gespeichert und wird nun geprüft.');
        } else {
            $("#linkToQuestEnabled").html('Es ist ein Fehler beim Speichern aufgetreten. :c Kontaktiere uns doch bitte!');
            $("#new-entry").fadeIn();
            $("#new-entry-text").fadeIn();
        }

    });

}

function withdrawQuest() {

    $.post("./ajax/withdrawQuest", {}, function (data) {
        data = jQuery.parseJSON(data);

        if (!data.error) {
            $("#withdraw-entry").html('Deine Quest wurde zurückgezogen, lade die Seite neu, um sie erneut einzureichen.');
        } else {
            $("#withdraw-entry").html('Fehler beim zurückziehen...');
        }

    });


}

function checkActiveTab() {

    var num = 1;
    var currFile = document.location.pathname;

    if (currFile == '/') {
        $("#nav_1").addClass('active-navitem');
        return;
    } else {
        currFile = document.location.pathname.match(/[^\/]+$/)[0];
    }


    $(".blacklnk").each(function () {
        var link = $(this).attr('href');
        link = link.substr(link.indexOf('.') + 1);
        link = link.substr(link.indexOf('/') + 1);
        
        if (currFile == link)  {
            $("#nav_" + currFile).addClass('active-navitem');
        }

        num++;
    });

}


function presentDialogWithText(message) {
    $(".alert").show();
    $("#alert-title").html(message);
    $("#popup_overlayhandler").fadeIn(300);
}

function presentTweetDialogWithText(message) {
    $(".tweet-window").show();
    //$("#alert-title").html(message);
    $("#popup_overlayhandler").fadeIn(300);
}


/* @ABENET_ CODE stuff zeug gedoens */

function editBio() {
    if ($('.userBio').is('[readonly]')) {
        $('.userBio').attr('readonly', false);
        $('#accessToggle').html('Save');
    } else {
        $('.userBio').attr('readonly', true);
        $('#accessToggle').html('Edit');
        var newBio = $('.userBio').val();
        $.post('../ajax/saveNewUserBio.php', {
            newUserBio: newBio
        });
        window.location.replace('/dashboard.php');
    }
}