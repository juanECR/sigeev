//funcion en caso de session acudacada
async function alerta_sesion() {
    Swal.fire({
        type: 'error',
        title: 'Error de Sesión',
        text: "Sesión Caducada, Por favor inicie sesión",
        confirmButtonClass: 'btn btn-confirm mt-2',
        footer: '',
        timer: 1000
    });
    location.replace(base_url + "login");
}


async function validar_datos_reset_password(){
    let id = document.getElementById('data').value;
    let token = document.getElementById('data2').value;

        const formData = new FormData();
        formData.append('id',id);
        formData.append('token',token);
        formData.append('sesion','');

            try {
                let respuesta = await fetch(base_url_server+'src/control/Usuario.php?tipo=validar_datos_reset_password', {
                    method: 'POST',
                    mode: 'cors',
                    cache: 'no-cache',
                    body: formData
                });
                let json = await respuesta.json();
                if (json.status == false) {
                    let form = document.getElementById("resetForm");
                    form.innerHTML = '';
                    let titulo = document.querySelector(".titulo");
                    titulo.innerHTML = '<p>Enlace invalido.</p>';
                    let caja = document.querySelector(".visual-side");
                    caja.innerHTML = '';
                    let btncreate = document.querySelector(".intro-text");
                    btncreate.innerHTML = '<a href="login" style="color:red;">Iniciar sesion</a>';
                }
                console.log(respuesta);
            } catch (e) {
                console.log("Error " + e);
            }
}

/* function validar_inputs_password(){
    let pass1 = document.getElementById('newPassword').value;
    let pass2 = document.getElementById('confirmPassword').value;
    if (pass1.length<8 && pass2.length<8) {
      Swal.fire({
                type: 'Error',
                title: 'Ingresa Minimo 8 caracteres',
                text: 'la contraseña Tiene que ser minimo 8 caracteres',
                footer: '',
                timer: 1500
            });
            return;
    }else if(pass1 != pass2){
        Swal.fire({
                type: 'error',
                title: 'Error',
                text: 'Las Contraseñas no coinciden',
                footer: '',
                timer: 1500
            });
            return;
    }else {
        actualizar_password(pass1);
    }
    
} */
async function actualizar_password(password) {
      //enviar informacion de password y id al controlador usuario
      // recibir infomacion y encriptar la nueva contraseña - controlador
      // guardar en base de datos y actualizar campo de reset password =0 y token passord = ''
      //notificacion a usuario sobre sobr el estado del proceso.
        let id = document.getElementById('data').value;
        const formData = new FormData();
        formData.append('id',id);
        formData.append('password',password);
        formData.append('sesion','');
        formData.append('token','');

            try {
                let respuesta = await fetch(base_url_server+'src/control/Usuario.php?tipo=restablecer_password', {
                    method: 'POST',
                    mode: 'cors',
                    cache: 'no-cache',
                    body: formData
                });
                let json = await respuesta.json();
                if (json.status) {
                        Swal.fire({
                        title: "Contraseña actualizada",
                        text: "Tu contraseña a sido modificada con exito",
                        icon: "success"
                        });
                        validar_datos_reset_password();

                }
                //console.log(respuesta);
            } catch (e) {
                console.log("Error " + e);
            }
}

(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Sidebar Toggler
    $('.sidebar-toggler').click(function () {
        $('.sidebar, .content').toggleClass("open");
        return false;
    });


    // Progress Bar
    $('.pg-bar').waypoint(function () {
        $('.progress .progress-bar').each(function () {
            $(this).css("width", $(this).attr("aria-valuenow") + '%');
        });
    }, {offset: '80%'});


    // Calender
    $('#calender').datetimepicker({
        inline: true,
        format: 'L'
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        items: 1,
        dots: true,
        loop: true,
        nav : false
    });


    // Chart Global Color
    Chart.defaults.color = "#6C7293";
    Chart.defaults.borderColor = "#000000";


    // Worldwide Sales Chart
    var ctx1 = $("#worldwide-sales").get(0).getContext("2d");
    var myChart1 = new Chart(ctx1, {
        type: "bar",
        data: {
            labels: ["2016", "2017", "2018", "2019", "2020", "2021", "2022"],
            datasets: [{
                    label: "USA",
                    data: [15, 30, 55, 65, 60, 80, 95],
                    backgroundColor: "rgba(235, 22, 22, .7)"
                },
                {
                    label: "UK",
                    data: [8, 35, 40, 60, 70, 55, 75],
                    backgroundColor: "rgba(235, 22, 22, .5)"
                },
                {
                    label: "AU",
                    data: [12, 25, 45, 55, 65, 70, 60],
                    backgroundColor: "rgba(235, 22, 22, .3)"
                }
            ]
            },
        options: {
            responsive: true
        }
    });


    // Salse & Revenue Chart
    var ctx2 = $("#salse-revenue").get(0).getContext("2d");
    var myChart2 = new Chart(ctx2, {
        type: "line",
        data: {
            labels: ["2016", "2017", "2018", "2019", "2020", "2021", "2022"],
            datasets: [{
                    label: "Salse",
                    data: [15, 30, 55, 45, 70, 65, 85],
                    backgroundColor: "rgba(235, 22, 22, .7)",
                    fill: true
                },
                {
                    label: "Revenue",
                    data: [99, 135, 170, 130, 190, 180, 270],
                    backgroundColor: "rgba(235, 22, 22, .5)",
                    fill: true
                }
            ]
            },
        options: {
            responsive: true
        }
    });
    


    // Single Line Chart
    var ctx3 = $("#line-chart").get(0).getContext("2d");
    var myChart3 = new Chart(ctx3, {
        type: "line",
        data: {
            labels: [50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150],
            datasets: [{
                label: "Salse",
                fill: false,
                backgroundColor: "rgba(235, 22, 22, .7)",
                data: [7, 8, 8, 9, 9, 9, 10, 11, 14, 14, 15]
            }]
        },
        options: {
            responsive: true
        }
    });


    // Single Bar Chart
    var ctx4 = $("#bar-chart").get(0).getContext("2d");
    var myChart4 = new Chart(ctx4, {
        type: "bar",
        data: {
            labels: ["Italy", "France", "Spain", "USA", "Argentina"],
            datasets: [{
                backgroundColor: [
                    "rgba(235, 22, 22, .7)",
                    "rgba(235, 22, 22, .6)",
                    "rgba(235, 22, 22, .5)",
                    "rgba(235, 22, 22, .4)",
                    "rgba(235, 22, 22, .3)"
                ],
                data: [55, 49, 44, 24, 15]
            }]
        },
        options: {
            responsive: true
        }
    });


    // Pie Chart
    var ctx5 = $("#pie-chart").get(0).getContext("2d");
    var myChart5 = new Chart(ctx5, {
        type: "pie",
        data: {
            labels: ["Italy", "France", "Spain", "USA", "Argentina"],
            datasets: [{
                backgroundColor: [
                    "rgba(235, 22, 22, .7)",
                    "rgba(235, 22, 22, .6)",
                    "rgba(235, 22, 22, .5)",
                    "rgba(235, 22, 22, .4)",
                    "rgba(235, 22, 22, .3)"
                ],
                data: [55, 49, 44, 24, 15]
            }]
        },
        options: {
            responsive: true
        }
    });


    // Doughnut Chart
    var ctx6 = $("#doughnut-chart").get(0).getContext("2d");
    var myChart6 = new Chart(ctx6, {
        type: "doughnut",
        data: {
            labels: ["Italy", "France", "Spain", "USA", "Argentina"],
            datasets: [{
                backgroundColor: [
                    "rgba(235, 22, 22, .7)",
                    "rgba(235, 22, 22, .6)",
                    "rgba(235, 22, 22, .5)",
                    "rgba(235, 22, 22, .4)",
                    "rgba(235, 22, 22, .3)"
                ],
                data: [55, 49, 44, 24, 15]
            }]
        },
        options: {
            responsive: true
        }
    });

    
})(jQuery);


