'use strict';

$(window).on('load', function () {

    var body = $('body');

    switch (body.attr('data-page')) {
        case "index":

            /* swiper carousel cardwiper */
            var swiper1 = new Swiper(".menuswiper", {
                spaceBetween: 20,
                slidesPerView: "auto",
                pagination: true,
                navigation: {
                  nextEl: '.swiper-button-next',
                  prevEl: '.swiper-button-prev',
                },
            });

    
            var swiper3 = new Swiper(".sliderswiper", {
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                spaceBetween: 20,
                autoHeight: true,
                pagination: false,
                autoScroll: true,
                navigation: {
                  nextEl: '.swiper-button-next',
                  prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: ".swiper-pagination",
                },
            });

            // var swiper4 = new Swiper(".topsponsorswiper", {
            //     autoplay: {
            //         delay: 3000,
            //         disableOnInteraction: false,
            //     },
            //     autoScroll: true,
            //     autoHeight: false,
            //     slidesPerView: 5,
            //     spaceBetween: 0,
            //     direction: "vertical",
            //     pagination: false
            // });

            // var swiper5 = new Swiper(".topincomeswiper", {
            //     autoplay: {
            //         delay: 3000,
            //         disableOnInteraction: false,
            //     },
            //     autoScroll: true,
            //     autoHeight: false,
            //     slidesPerView: 5,
            //     spaceBetween: 0,
            //     direction: "vertical",
            //     pagination: false
            // });
            // var swiper7 = new Swiper(".peringkatswiper", {
            //     autoplay: {
            //         delay: 3000,
            //         disableOnInteraction: false,
            //     },
            //     autoScroll: true,
            //     autoHeight: false,
            //     slidesPerView: 5,
            //     spaceBetween: 0,
            //     direction: "vertical",
            //     pagination: false
            // });
            
            var swiper6 = new Swiper(".poinswiper", {
                slidesPerView: "auto",
                spaceBetween: 15
            });
            

            break;
        case "profile":
            
            // var swiper1 = new Swiper(".cardswiper", {
            //     slidesPerView: "auto",
            //     spaceBetween: 0,
            //     pagination: false
            // });
            break;
    }

});
