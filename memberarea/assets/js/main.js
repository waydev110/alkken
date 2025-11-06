'use strict'
$(document).ready(function () {

    var body = $('body');
    var bodyParent = $('html');

    /* page load as iframe */
    if (self !== top) {
        body.addClass('iframe');
    } else {
        body.removeClass('iframe');
    }

    /* menu open close */
    $('.menu-btn').on('click', function () {
        if (body.hasClass('menu-open') === true) {
            body.removeClass('menu-open');
            bodyParent.removeClass('menu-open');
        } else {
            body.addClass('menu-open');
            bodyParent.addClass('menu-open');
        }

        return false;
    });

    body.on("click", function (e) {
        if (!$('.sidebar').is(e.target) && $('.sidebar').has(e.target).length === 0) {
            body.removeClass('menu-open');
            bodyParent.removeClass('menu-open');
        }

        return true;
    });



    /* menu style switch */
    $('#menu-pushcontent').on('change', function () {
        if ($(this).is(':checked') === true) {
            body.addClass('menu-push-content');
            body.removeClass('menu-overlay');
        }

        return false;
    });

    $('#menu-overlay').on('change', function () {
        if ($(this).is(':checked') === true) {
            body.removeClass('menu-push-content');
            body.addClass('menu-overlay');
        }

        return false;
    });


    /* back page navigation */
    $('.back-btn').on('click', function () {
        window.history.back();
        return false;
    });


    /** center button click toggle **/
    // $('.centerbutton .nav-link').on('click', function () {
    //     $(this).toggleClass('active')
    // })
    
});


$(window).on('load', function () {
    setTimeout(function () {
        $('.loader-wrap').fadeOut('slow');
    }, 200);


    /* coverimg */
    $('.coverimg').each(function () {
        var imgpath = $(this).find('img');
        $(this).css('background-image', 'url(' + imgpath.attr('src') + ')');
        imgpath.hide();
    })

    
    /* url path on menu */
    var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
    $(' .main-menu ul a').each(function () {
        if (this.href === path) {
            $(' .main-menu ul a').removeClass('active');
            $(this).addClass('active');
        }
    });

    /* main container min height */
    $('main').css('min-height', $(window).height());
	
    if ($('.header.position-fixed').length > 0) {
        $('main').css('padding-top', $('.header').outerHeight() - 2);
    }
    if ($('.footer').length > 0) {
        $('main').css('padding-bottom', $('.footer').outerHeight() - 2);
    }

    
});


$(window).on('scroll', function () {

    /* scroll from top and add class */
    if ($(document).scrollTop() > '10') {
        $('.header.position-fixed').addClass('active');
    } else {
        $('.header.position-fixed').removeClass('active');
    }
});


$(window).on('resize', function () {
    /* main container min height */
    $('main').css('min-height', $(window).height())
});

function loader_open(){    
    $('.waiting-wrap').fadeIn();
}

function loader_close(){    
    $('.waiting-wrap').fadeOut('fast');
}
var btnText = '';

function btn_proses_start(e){    
    btnText = $(e).html();
    $(e).html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    Loading...`);
    $(e).prop('disabled', true);
}

function btn_proses_end(e){    
    $(e).html(btnText);
    $(e).prop('disabled', false);
}

function btn_start(){  
    var btn = $('#btnSubmitPIN');  
    btn.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    Loading...`);
    btn.prop('disabled', true);
}

function btn_finish(){    
    var btn = $('#btnSubmitPIN');    
    btn.html('Submit');
    btn.prop('disabled', false);
}
function redirect(url){   
    window.location = '?go='+url;
}

function show_success(message = '', url = ''){
    $('main').children().remove();
        var html = `<header class="header position-fixed">`;
        if(url != ''){
        html += `<div class="row">
                    <div class="col-auto">
                        <a href="index.php?go=${url}" class="btn btn-light btn-44 back-btn text-muted">
                            <i class="fas fa-times-circle"></i>
                        </a>
                    </div>
                </div>`;      
        }
        html += `</header>
        <div class="main-container container mt-4 pt-0" id="blockSukses">      
            <div class="row">
                <div class="col-12 mb-3 text-center">
                    <div class="avatar avatar-70 bg-success text-white rounded-circle size-22 mb-2">
                        <i class="fas fa-check"></i>
                    </div>
                    <p class="text-center text-success fw-bold mb-2 size-18">Berhasil</p>
                </div>`;
    if(message != ''){
        html += `<div class="col-12 mb-3 text-center px-5">
                    <p class="text-center text-muted mb-2 size-12">${message}</p>
                </div>`;       
    }
    if(url != ''){
        html += `<div class="col-6 offset-3 d-grid mb-4">
                    <a href="index.php?go=${url}" class="btn btn-default btn-lg shadow-sm">Ok</a>
                </div>`;      
    }
    html += `</div>
        </div>`;
    $('main').append(html);
}

function show_success_profil(message = '', url = ''){
    $('main').children().remove();
        var html = `<header class="header position-fixed">`;
        if(url != ''){
        html += `<div class="row">
                    <div class="col-auto">
                        <a href="index.php?go=${url}" class="btn btn-light btn-44 back-btn text-muted">
                            <i class="fas fa-times-circle"></i>
                        </a>
                    </div>
                </div>`;      
        }
        html += `</header>
        <div class="main-container container mt-4 pt-0" id="blockSukses">      
            <div class="row">
                <div class="col-12 mb-3 text-center">
                    <div class="avatar avatar-70 bg-success text-white rounded-circle size-22 mb-2">
                        <i class="fas fa-check"></i>
                    </div>
                    <p class="text-center text-success fw-bold mb-2 size-18">Berhasil</p>
                </div>`;
    if(message != ''){
        html += `<div class="col-12 mb-3 text-center px-5">
                    <p class="text-center text-muted mb-2 size-12">${message}</p>
                </div>`;       
    }
    if(url != ''){
        html += `<div class="col-6 offset-3 d-grid mb-4">
                    <a href="${url}" class="btn btn-default btn-lg shadow-sm">Gabung Grup WA</a>
                </div>`;      
    }
    html += `</div>
        </div>`;
    $('main').append(html);
}

function show_success_html(message = '', url = ''){
    $('main').children().remove();
        var html = `<header class="header position-fixed">`;
        if(url != ''){
        html += `<div class="row">
                    <div class="col-auto">
                        <a href="index.php?go=${url}" class="btn btn-light btn-44 back-btn text-muted">
                            <i class="fas fa-times-circle"></i>
                        </a>
                    </div>
                </div>`;      
        }
        html += `</header>
        <div class="main-container container mt-4 pt-0" id="blockSukses">      
            <div class="row">
                <div class="col-12 mb-3 text-center">
                    <div class="avatar avatar-70 bg-success text-white rounded-circle size-22 mb-2">
                        <i class="fas fa-check"></i>
                    </div>
                    <p class="text-center text-success fw-bold mb-2 size-18">Berhasil</p>
                </div>`;
    if(message != ''){
        html += `<div class="col-12 mb-3 text-center px-5">
                    ${message}
                </div>`;       
    }
    if(url != ''){
        html += `<div class="col-6 offset-3 d-grid mb-4">
                    <a href="index.php?go=${url}" class="btn btn-default btn-lg shadow-sm">Ok</a>
                </div>`;      
    }
    html += `</div>
        </div>`;
    $('main').append(html);
}

function show_success_html_message(message = '', url = ''){
    $('main').children().remove();
        var html = ``;
    if(message != ''){
        html += `<div class="col-12 mb-3 text-center px-5">
                    ${message}
                </div>`;       
    }
    if(url != ''){
        html += `<div class="col-6 offset-3 d-grid mb-4">
                    <a href="index.php?go=${url}" class="btn btn-default btn-lg shadow-sm">Ok</a>
                </div>`;      
    }
    html += `</div>
        </div>`;
    $('main').append(html);
}

function show_error(message = '', url = ''){
    $('main').children().remove();
    var html = `<header class="header position-fixed">`;
    if(url != ''){
    html += `<div class="row">
                <div class="col-auto">
                    <a href="index.php?go=${url}" class="btn btn-light btn-44 back-btn text-muted">
                        <i class="fas fa-times-circle"></i>
                    </a>
                </div>
            </div>`;      
    }
    html += `</header>
        <div class="main-container container mt-4 pt-0" id="blockError">
            <div class="row">
                <div class="col-12 mb-3 text-center">
                    <div class="avatar avatar-70 bg-danger text-white rounded-circle size-22 mb-2">
                        <i class="fas fa-times"></i>
                    </div>
                    <p class="text-center text-danger fw-bold mb-2 size-18">Gagal</p>
                </div>`;
    if(message != ''){
        html += `<div class="col-12 mb-3 text-center px-5">
                    <p class="text-center text-muted mb-2 size-12">${message}</p>
                </div>`;        
    }
    if(url != ''){
        html += `<div class="col-6 offset-3 d-grid mb-4">
                    <a href="index.php?go=${url}" class="btn btn-default btn-lg shadow-sm">Ok</a>
                </div>`;      
    }
    html += `</div>
        </div>`;
    $('main').append(html);
}