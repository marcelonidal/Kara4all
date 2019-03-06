//====================================================
// ABRE A CATEGORIA
//====================================================

$("#mainNav").on('click', '#nacional', function () {
    var param = {'category': 'NAC'};
    $("#category").html("");
    addCategory(param);
});

$("#mainNav").on('click', '#internacional', function () {
    var param = {'category': 'INTER'};
    $("#category").html("");
    addCategory(param);
});

//====================================================
// FECHA CATEGORIA
//====================================================

$("#category").on('click', '#closeCategory', function () {
    $("#category").html("");
    $("#home").show();
    $("#homeBtn").show();
    hideAll();
});

//====================================================
// ADICIONA O MAIN
//====================================================
function addCategory(param) {
    $.ajax({
        type: 'POST',
        url: './category/main_category.php',
        data: param,
        dataType: "html",
        beforeSend: function () {
            $('body').toggleClass('loading');
        },
        success: function (data) {
            $('body').removeClass('loading');
            scrollToElement($('#home'));
            $("#home").hide();
            $("#homeBtn").hide();
            $('#category').append(data);

            list_songs(param);
        },
        error: function (xhr) {
            toastr.error('Status: ' + xhr.statusText + ' Resp: ' + xhr.responseText);
        }
    })
}

//====================================================
// LISTA SONGS
//====================================================
function list_songs(category) {

    $.ajax({
        type: 'POST',
        data: category,
        url: './category/list_category.php',
        beforeSend: function () {
            $('body').toggleClass('loading');
        },
        success: function (data) {
            $('body').removeClass('loading');
            //console.log("###########" + data);
            $("#categoryBody").html(data).fadeIn('slow');
            $('#categoryTable').DataTable({
                "pagingType": "full_numbers", // "simple"
                "order": [[0, 'asc']],
                "language": {
                    "search": "Busca:",
                    "lengthMenu": "Mostrar _MENU_ músicas por página",
                    "zeroRecords": "Nada encontrado!",
                    "emptyTable": "Sem músicas disponíveis nesta categoria",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "Mostrando página 0 de 0",
                    "infoFiltered": "(filtrado de _MAX_ músicas)",
                    "paginate": {
                        "first": "Primeira",
                        "last": "Última",
                        "next": "Próxima",
                        "previous": "Anterior"
                    }
                }
            });
            $('.dataTables_length').addClass('bs-select');

            toastr.info("Para adicionar as músicas na fila, basta clicar na  música desejada!");
            //====================================================
            // CONTEXTO PARA ADD MODAL
            //====================================================
            $('#category').on('click' , '#btnAddQueueList2', function () {
                $('#category').html("");
                $('#home').show();
                $('#homeBtn').show();
                addQueue();
            });

            $("#categoryBody").hover(function () {
                $(this).css('cursor', 'pointer');
            });

            $("#categoryBody").on('click', 'tr', function () {
                var music = $(this).text();
                if (!music.includes('Código:')) {
                    music = music.trim().split("\n");
                    for (i = 0; i < music.length; i++) {
                        music[i] = music[i].trim();
                    }
                    openOrder(music, category);
                }
            });
        }
    })
}

//====================================================
// ABRE ORDER
//====================================================
function openOrder(music, category) {

    var parametros = {'id': music[0], 'title': music[1], 'artist': music[2], 'category': category['category']};

    $.ajax({
        type: 'POST',
        data: parametros,
        url: './admin/addOrder.php',
        beforeSend: function () {
            $('body').toggleClass('loading');
        },
        success: function (data) {

            $('body').removeClass('loading');

            if (data.startsWith("[")) {
                $('#home').show();
                $('#homeBtn').show();
                $('#category').html("");
                openQueue(parametros);
            } else {
                $('#category').append(data);
                scrollToElement($('#home'));
                $("#addOrderModal").modal("show");

                $('#addOrderModal').on('hidden.bs.modal', function () {
                    $('#addOrderModal').detach();
                });

                $("#addOrderModal").on('click', '#navLogin', function () {
                    $("#addOrderModal").modal("hide");
                    $('#addOrderModal').detach();
                    $('#category').hide();
                    $('#category').html("");
                    insereLogin();
                });

                $("#addOrderModal").on('click', '#navRegister', function () {
                    $("#addOrderModal").modal("hide");
                    $('#addOrderModal').detach();
                    $('#category').hide();
                    $('#category').html("");
                    insereRegistro();
                });

                $("#addOrderModal").on('click', '#insertOrder', function () {
                    $('#insertOrder').attr("disabled","disabled");
                    insertOrder(parametros);
                });
            }
        }
    })
}

//====================================================
// INSERT ORDER
//====================================================
function insertOrder(param) {

    $.ajax({
        type: 'POST',
        data: param,
        url: './bd/queue.php',
        beforeSend: function () {
            $('body').toggleClass('loading');
        },
        success: function (data) {
            $('body').removeClass('loading');
           // console.log('FILA= ' + data);
            if (data == 'OK') {
                $("#addOrderModal").modal("hide");
                $('#addOrderModal').detach();
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