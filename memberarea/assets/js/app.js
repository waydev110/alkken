'use strict';

$(window).on('load', function () {

    var body = $('body');

    switch (body.attr('data-page')) {
        case "splash":
            setTimeout(function () {
                window.location.replace("landing.html");
            }, 4000)
            break;


        case "thankyou":
            setTimeout(function () {
                window.location.replace("index.html");
            }, 4000)
            break;

        case "signin":
            var passworderrorEl = document.getElementById('passworderror')
            var tooltip = new bootstrap.Tooltip(passworderrorEl, {
                boundary: document.body // or document.querySelector('#boundary')
            })
            break;

        case "signup":
            var passworderrorEl = document.getElementById('passworderror')
            var tooltip = new bootstrap.Tooltip(passworderrorEl, {
                boundary: document.body // or document.querySelector('#boundary')
            })
            break;

        case "index":

            /* request money notification remove after time*/
            $('.hideonprogressbar').each(function () {
                var thisEl = $(this);
                var hidelment = "." + thisEl.attr('data-target')
                var widthprogress = 1;

                setInterval(function () {
                    widthprogress++;
                    if (widthprogress > 0 && widthprogress < 100) {
                        thisEl.find('.progress-bar').css('width', widthprogress + "%");

                    } else if (widthprogress === 100) {
                        $(hidelment).fadeOut();
                    }
                }, 75)

            })

            /* Progress circle */
            var progressCircles1 = new ProgressBar.Circle(circleprogressone, {
                color: '#7297F8',
                // This has to be the same size as the maximum width to
                // prevent clipping
                strokeWidth: 10,
                trailWidth: 10,
                easing: 'easeInOut',
                trailColor: '#d8e0f9',
                duration: 1400,
                text: {
                    autoStyleContainer: false
                },
                from: { color: '#7297F8', width: 10 },
                to: { color: '#7297F8', width: 10 },
                // Set default step function for all animate calls
                step: function (state, circle) {
                    circle.path.setAttribute('stroke', state.color);
                    circle.path.setAttribute('stroke-width', state.width);

                    var value = Math.round(circle.value() * 100);
                    if (value === 0) {
                        // circle.setText('');
                    } else {
                        //  circle.setText(value + "<small>%<small>");
                    }

                }
            });
            // progressCircles1.text.style.fontSize = '20px';
            progressCircles1.animate(0.65);  // Number from 0.0 to 1.0

            var progressCircles2 = new ProgressBar.Circle(circleprogresstwo, {
                color: '#3AC79B',
                // This has to be the same size as the maximum width to
                // prevent clipping
                strokeWidth: 10,
                trailWidth: 10,
                easing: 'easeInOut',
                trailColor: '#d8f4eb',
                duration: 1400,
                text: {
                    autoStyleContainer: false
                },
                from: { color: '#3AC79B', width: 10 },
                to: { color: '#3AC79B', width: 10 },
                // Set default step function for all animate calls
                step: function (state, circle) {
                    circle.path.setAttribute('stroke', state.color);
                    circle.path.setAttribute('stroke-width', state.width);

                    var value = Math.round(circle.value() * 100);
                    if (value === 0) {
                        //  circle.setText('');
                    } else {
                        // circle.setText(value + "<small>%<small>");
                    }

                }
            });
            // progressCircles2.text.style.fontSize = '20px';
            progressCircles2.animate(0.85);  // Number from 0.0 to 1.0



            /* swiper carousel cardwiper */
            var swiper1 = new Swiper(".cardswiper", {
                slidesPerView: "auto",
                spaceBetween: 0,
                pagination: false
            });

            /* swiper carousel connectionwiper */
            var swiper2 = new Swiper(".connectionwiper", {
                slidesPerView: "auto",
                spaceBetween: 0,
                pagination: true,
                navigation: {
                  nextEl: '.swiper-button-next',
                  prevEl: '.swiper-button-prev',
                },
            });

            /* app install toast message */
            var toastElList = document.getElementById('toastinstall');
            var toastElinit = new bootstrap.Toast(toastElList, {
                // autohide: "!1",
                autohide: true,
                delay: 5000,
            });
            toastElinit.show();

            /* PWA add to phone Install ap button */
            var btnAdd = document.getElementById('addtohome');
            var defferedPrompt;
            window.addEventListener("beforeinstallprompt", function (event) {
                event.preventDefault();
                defferedPrompt = event;

                btnAdd.addEventListener("click", function (event) {
                    defferedPrompt.prompt();


                    defferedPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('User accepted the A2HS prompt');
                        } else {
                            console.log('User dismissed the A2HS prompt');
                        }
                        defferedPrompt = null;
                    });
                });
            });

            break;

        
    }

});
