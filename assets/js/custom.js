$(document).ready(function () {

    /*************************************** New gamer *************************************/

    var $new_gamer = $('#new_gamer');
    $new_gamer.on('submit', function () {
        var $this = $(this);

        $.ajax({
            url: $this.attr('action'),
            method: $this.attr('method'),
            data: $this.serializeArray(),
            dataType: 'json',
            success: function (response) {
                location.reload();
            },
            error: function (response) {
                var errrorsHtml = '';
                var errors = response.responseJSON.errors;
                $.each(errors, function (key,value) {
                    errrorsHtml += value +"\n";
                });
                alert(errrorsHtml);
            },
            fail: function () {
                alert('Problem happened');
            }
        });

        return false;

    });


    var $battle_area = $('.battle_area');
    var $start_game = $('.start_game');
    var $battle_area_square = $('.battle_area_square');
    var shipPlacement = [];
    var shipSquares = 0;
    var hits = 0;
    var misses = 0;
    var max_misses = 0;

    /**
     * Start game
     */
    $start_game.on('submit', function () {
        var $this = $(this);
        $.ajax({
            url: $this.attr('action'),
            method: $this.attr('method'),
            dataType: 'json',
            success: function (response) {
                $battle_area.removeClass('hidden');
                $this.remove();
                shipPlacement = response.game_matrix;
                shipSquares = response.total_targets;
                max_misses = response.max_misses;

            },
            error: function (response) {
                console.log(response);
                var errorsHtml = '';
                var errors = response.responseJSON.errors;
                $.each(errors, function (key,value) {
                    errorsHtml += value +"\n";
                });
                alert(errorsHtml);
            },
            fail: function () {
                alert('Problem happened');
            }
        });

        return false;
    });


    $battle_area_square.on('click', function () {
        var $this = $(this);
        var bas_raw = $this.data('row');
        var bas_column = $this.data('column');

        if (shipPlacement[bas_raw][bas_column] === 1) {
            if ($this.hasClass('bg-red') === false) {
                hits += 1;
                $this.addClass('bg-red');
                $('.hit_number').html(hits);
            }
        }
        else if ($this.hasClass('bg-white') === false) {
            misses += 1;
            $this.addClass('bg-white');

            $('.miss_number').html(misses);
        }

        if (hits === shipSquares) {
            alert('You sunk all the ships! You win :)');
            saveGame(1)
        }

        if (misses === max_misses) {
            alert('You have missed ' + max_misses+' times ! Game over');
            saveGame(0)
        }

    });

    /**
     * Funtion to save finished game in the database
     */

    function saveGame(has_won) {
        var $this = $('.battle_area');
        $.ajax({
            url: $this.attr('action'),
            method: $this.attr('method'),
            data: {has_won: has_won},
            dataType: 'json',
            success: function (response) {
                alert(response.message)
                location.reload();
            },
            error: function (response) {
                console.log(response);
                var errorsHtml = '';
                var errors = response.responseJSON.errors;
                $.each(errors, function (key,value) {
                    errorsHtml += value +"\n";
                });
                alert(errorsHtml);
            },
            fail: function () {
                alert('Problem happened');
            }
        });
    }



});