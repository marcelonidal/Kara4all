//====================================================
// CARREGA O FLYER DISPONIVEL
//====================================================
$(document).ready(function () {
    loadFlyer();
});

function loadFlyer() {
    $.ajax({
        type: "POST",
        url: './home/loadFlyer.php',
        dataType: "html",
        success: function (data) {
            $('#profile').html("");
            $('#register').html("");
            $('#topRegister').hide();
            $('#bottomRegister').hide();
            $('#home').html(data);
            $('#bottomHome').show();
            scrollToElement($('#home'));
        },
        error: function (xhr) {
            toastr.error('Status: ' + xhr.statusText + ' Resp: ' + xhr.responseText);
        }
    })
}

//====================================================
// INSERE OS BOTOES ADMIN
//====================================================
$('#homeBtn').on('click', '#btnAddQueueList', function () {
    $('#category').html("");
    addQueue();
})

$('#homeBtn').on('click', '#btnAddEvent', function () {
    openEvent();
})

$('#homeBtn').on('click', '#btnAddSongList', function () {
    openUploadList();
})

$('#homeBtn').on('click', '#btnAddQueue', function () {
    openQueue();
})

//====================================================
// FECHA MENU
//====================================================
$('#navbarResponsive').on('click', '#navLogin, #navLogout, #navProfile, #nacional, #internacional', function () {
    hideAll();
    $('#category').show();
    $('#navbarResponsive').collapse('hide');
});

//====================================================
// ABRE MODAL EVENT
//====================================================
function openEvent() {
    var parametros = null;

    $.ajax({
        type: 'POST',
        url: './admin/addEvent.php',
        beforeSend: function () {
            $('body').toggleClass('loading');
        },
        success: function (data) {
            $('body').removeClass('loading');
            $('#home').append(data);
            scrollToElement($('#home'));
            $("#addEventModal").modal("show");

            $('#addEventModal').on('hidden.bs.modal', function () {
                $('#addEventModal').detach();
            });

            $(function () {
                $('#datepicker').datepicker({
                    showOn: "focus",
                    dateFormat: "dd/mm/yy",
                    dayNames: ["Domingo", "Segunda", "Terça", "Quarte", "Quinta", "Sexta", "Sábado"],
                    dayNamesMin: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
                    monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']
                });
            });

            $(function () {
                $('#timepicker').timepicki({
                    show_meridian: false,
                    min_hour_value: 0,
                    max_hour_value: 23,
                    step_size_minutes: 15,
                    overflow_minutes: false,
                    increase_direction: 'up',
                    disable_keyboard_mobile: true
                });
            });

            $("#addEventModal").on('click', '#insertEvent', function () {

                parametros = {
                    'data': $('#datepicker').val(),
                    'hora': $('#timepicker').val(),
                    'local': $("#local").val()
                };

                //console.log(JSON.stringify(parametros));
                if (parametros['data'].length > 0 && parametros['hora'].length > 0 && parametros['local'].length > 0) {
                    $("#addEventModal").modal("hide");
                    $('#addEventModal').detach();
                    insertEvent(parametros);
                } else {
                    toastr.error('Preencha os campos vazios!');
                }
            });

            $("#addEventModal").on('click', '#btnFlyer', function () {
                parametros = {
                    'data': $('#datepicker').val(),
                    'hora': $('#timepicker').val(),
                    'local': $("#local").val()
                };

                $("#addEventModal").modal("hide");
                $('#addEventModal').detach();
                openUploadFlyer(parametros);
            });
        }
    })
}

//====================================================
// INSERT EVENT
//====================================================
function insertEvent(param) {

    $.ajax({
        type: 'POST',
        data: param,
        url: './bd/event.php',
        beforeSend: function () {
            $('body').toggleClass('loading');
        },
        success: function (data) {
            //console.log('INFO= ' + data);
            $('body').removeClass('loading');
            if (data == 'OK') {
                toastr.info('Evento inserido com sucesso!');
            } else {
                toastr.warning('Falha ao salvar o evento!');
            }
        },
        error: function (xhr) {
            toastr.error('Status: ' + xhr.statusText + ' Resp: ' + xhr.responseText);
        }
    })
}

//====================================================
// ABRE MODAL UPLOAD EVENT
//====================================================
function openUploadFlyer(paramEvent) {

    $.ajax({
        type: 'POST',
        url: './admin/addFlyer.php',
        beforeSend: function () {
            $('body').toggleClass('loading');
        },
        success: function (data) {
            $('body').removeClass('loading');
            $('#home').append(data);
            scrollToElement($('#home'));
            $("#addUploadFlyerModal").modal("show");

            $('#addUploadFlyerModal').on('hidden.bs.modal', function () {
                $('#addUploadFlyerModal').detach();
                loadModalEvent(paramEvent);
            });

            $("#addUploadFlyerModal").on('click', '#uploadFlyer', function () {
                $('#uploadFlyer').attr("disabled", "disabled");
                var formData = new FormData();
                var files = $('#fileToUpload')[0].files[0];
                formData.append('file', files);
                formData.append('tipoUpload', 'flyer');

                $.ajax({
                    url: './admin/upload.php',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        //console.log('resp= ' + data);

                        if (!data.includes('NOK')) {
                            var msg = 'Upload do arquivo: ';
                            data = JSON.parse(data);
                            var lastIndex = data.lastIndexOf("/");
                            msg += data.slice(lastIndex + 1, data.length);
                            toastr.info(msg);
                            $('#addUploadFlyerModal').modal("hide");
                            $('#addUploadFlyerModal').detach();
                        } else {
                            toastr.warning('Falha no upload!');
                        }
                    },
                });
            });

        },
        error: function (xhr) {
            toastr.error('Status: ' + xhr.statusText + ' Resp: ' + xhr.responseText);
        }
    })
}

//====================================================
// RELOAD NOS DADOS DO MODAL EVENT
//====================================================
function loadModalEvent(param) {
    openEvent();

    setTimeout(function () {
        $('#datepicker').val(param['data']);
        $('#timepicker').val(param['hora']);
        $("#local").val(param['local']);
    }, 500);
}

//====================================================
// ABRE MODAL UPLOAD LIST
//====================================================
function openUploadList() {

    $.ajax({
        type: 'POST',
        url: './admin/addList.php',
        beforeSend: function () {
            $('body').toggleClass('loading');
        },
        success: function (data) {
            $('body').removeClass('loading');
            $('#home').append(data);
            scrollToElement($('#home'));
            $("#addUploadListModal").modal("show");

            $('#addUploadListModal').on('hidden.bs.modal', function () {
                $('#addUploadListModal').detach();
            });

            $("#addUploadListModal").on('click', '#uploadList', function () {
                $('#uploadList').attr("disabled", "disabled");
                var formData = new FormData();

                if ($('#fileToUpload1')[0].files[0] == undefined || $('#fileToUpload2')[0].files[0] == undefined) {
                    toastr.error("Selecione os arquivos pra upload!");
                } else {
                    var file1 = $('#fileToUpload1')[0].files[0];
                    var file2 = ($('#fileToUpload2')[0].files[0]);

                    formData.append('file1', file1);
                    formData.append('file2', file2);
                    formData.append('tipoUpload', 'listas');

                    $.ajax({
                        url: './admin/upload.php',
                        type: 'post',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            //console.log('resp= ' + data);
                            if (!data.includes('NOK')) {
                                var msg = 'Upload do arquivo: ';
                                data = JSON.parse(data);
                                var size = data.length;
                                for (var i = 0; i < size; i++) {
                                    var lastIndex = data[i].lastIndexOf("/");
                                    msg += data[i].slice(lastIndex + 1, data[i].length) + "<br/>";
                                }
                                toastr.info(msg);
                                $('#addUploadListModal').modal("hide");
                                $('#addUploadListModal').detach();
                                insertSongs();
                            } else {
                                toastr.warning('Falha no upload!');
                            }
                        },
                    });
                }
            });

        },
        error: function (xhr) {
            toastr.error('Status: ' + xhr.statusText + ' Resp: ' + xhr.responseText);
        }
    })
}

//====================================================
// INSERE AS MUSICAS DO ULTIMO CSV - BUSCA POR DATA
//====================================================
function insertSongs() {

    $.ajax({
        type: "POST",
        url: './admin/addSongs.php',
        beforeSend: function () {
            $('body').toggleClass('loading');
        },
        success: function (data) {
            //INSERT DA LISTA NAC E INTER
            $('body').removeClass('loading');
            if (data == 'OKOK') {
                toastr.info('Update das listas realizado com sucesso!');
            } else {
                toastr.error('Falha no Update das listas!');
            }
        },
        error: function (xhr) {
            toastr.error('Status: ' + xhr.statusText + ' Resp: ' + xhr.responseText);
        }
    })
}

//====================================================
// ABRE ADD MUSICA NA FILA - SO ADMIN
//====================================================
function openQueue(param) {

    $.ajax({
        type: 'POST',
        url: './queue/addQueue.php',
        beforeSend: function () {
            $('body').toggleClass('loading');
        },
        success: function (data) {
            $('body').removeClass('loading');
            $('#home').append(data);
            scrollToElement($('#home'));
            $("#addQueueModal").modal("show");

            $('#musica').val(param['id']);
            $('#categoria').val(param['category']);

            $('#addQueueModal').on('hidden.bs.modal', function () {
                $('#addQueueModal').detach();
            });

            $("#addQueueModal").on('click', '#insertQueue', function () {
                $('#insertQueue').attr("disabled", "disabled");

                var parametros = null;
                parametros = {
                    'convidado': $('#convidado').val(),
                    'categoria': $('#categoria').val(),
                    'cod_musica': $("#musica").val()
                };
                //console.log(JSON.stringify(parametros));
                if (parametros['convidado'].length > 0 && parametros['cod_musica'].length > 0) {
                    $("#addQueueModal").modal("hide");
                    $('#addQueueModal').detach();
                    insertQueue(parametros);
                } else {
                    toastr.error('Preencha os campos vazios!');
                }
            });
        }
    })
}

//====================================================
// INSERT QUEUE
//====================================================
function insertQueue(param) {

    $.ajax({
        type: 'POST',
        data: param,
        url: './bd/queue.php',
        beforeSend: function () {
            $('body').toggleClass('loading');
        },
        success: function (data) {
            $('body').removeClass('loading');
            //console.log('FILA ADM= ' + data);
            if (data == 'OK') {
                toastr.info('Musica adicionada com sucesso na fila!');
            } else {
                toastr.warning('Falha inserir musica na fila!');
            }
        },
        error: function (xhr) {
            toastr.error('Status: ' + xhr.statusText + ' Resp: ' + xhr.responseText);
        }
    })
}

//====================================================
// INSERE MAIN DA FILA
//====================================================
function addQueue() {

    var countdown = 20;
    startCountdown(countdown);

    $.ajax({
        type: 'POST',
        url: './queue/mainQueue.php',
        beforeSend: function () {
            $('body').toggleClass('loading');
        },
        success: function (data) {
            $('body').removeClass('loading');
            $('#home').html("");
            $('#homeBtn').html("");
            $('#home').append(data);
            scrollToElement($('#home'));
            listQueue();
        },
        error: function (xhr) {
            toastr.error('Status: ' + xhr.statusText + ' Resp: ' + xhr.responseText);
        }
    })
}

//====================================================
// REFRESH DA FILA
//====================================================
function startCountdown(count) {
    var n = count;
    var interval = null;
    setTimeout(function () {
        var iniText = "(Atualização em " + count + " segundos!)";
        $('#queueInfo').html(iniText);
        interval = setInterval(function () {
            var currentText = $('#queueInfo').text();
            var newText = currentText.replace(n, n - 1);
            $('#queueInfo').html(newText);
            if (n < 2) {
                if ($('#queueInfo').html() == undefined) {
                    clearInterval(interval);
                } else {
                    clearInterval(interval);
                    addQueue();
                }
            }
            n--;
        }, 1000);
        //PARAR INTERVAL
        $('#closeQueue, #reloadHome, #btnDelSong, #btnClearQueue, #btnStopRefresh').on('click', function () {
            clearInterval(interval);
        });

        $('#nacional, #internacional').on('click', function () {
            clearInterval(interval);
            $('#home, #homeBtn').html("");
            loadFlyer();
        });
    }, 500);
    clearInterval(interval);
}

//====================================================
// FECHA FILA
//====================================================
$("#home").on('click', '#closeQueue', function () {
    $("#home").html("");
    $("#homeBtn").html("");
    loadFlyer();
});

//====================================================
// LISTA FILA
//====================================================
function listQueue() {

    $.ajax({
        type: 'POST',
        url: './queue/listQueue.php',
        beforeSend: function () {
            $('body').toggleClass('loading');
        },
        success: function (data) {
            $('body').removeClass('loading');
            //console.log("###########" + data);
            $("#queueBody").html(data).fadeIn('slow');

            $("#delFromQueue").on('click', '#btnDelSong', function () {
                $('body').toggleClass('loading');
                delFromQueue();
                $("#home").html("");
                $("#homeBtn").html("");
                addQueue();
            });

            $("#delFromQueue").on('click', '#btnClearQueue', function () {
                $('body').toggleClass('loading');
                clearQueue();
                $("#home").html("");
                $("#homeBtn").html("");
                addQueue();
            })
        }
    })
}

//====================================================
// REMOVE PRIMEIRA MUSICA DA FILA
//====================================================
function delFromQueue() {

    $.ajax({
        type: 'POST',
        url: './bd/delFromQueue.php',
        beforeSend: function () {
            $('body').toggleClass('loading');
        },
        success: function (data) {
            $('body').removeClass('loading');
            //console.log("###########" + data);
            if (data == 'OK') {
                toastr.info('Musica removida com sucesso da fila!');
            } else {
                toastr.warning('Falha na remocao da musica!');
            }
        }
    })
}

//====================================================
// LIMPA FILA
//====================================================
function clearQueue() {

    $.ajax({
        type: 'POST',
        url: './bd/clearQueue.php',
        beforeSend: function () {
            $('body').toggleClass('loading');
        },
        success: function (data) {
            $('body').removeClass('loading');
            //console.log("###########" + data);
            if (data == 'OK') {
                toastr.info('Fila removida com sucesso da fila!');
            } else {
                toastr.warning('Falha na remocao da fila!');
            }
        }
    })
}