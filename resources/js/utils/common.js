export default class common {
     /*static getImgUrl(pet) {
         require('../../assets/logo.png')
        return images('./' + pet + ".png")
     }*/

    static getConfig(){
        var config = {
            medecin:{
                link: '/doctor',
                home: 'doctor',
                title: 'Doctors',
                cardTitle: 'Doctor Parameters'
            },
            garagiste:{
                link: '/cars',
                home: 'cars',
                title: 'Cars',
                cardTitle: 'Cars Parameters'
            },
            beauty:{
                link: '/body-care',
                home: 'body',
                title: 'Body care',
                cardTitle: 'Artister Parameters'
            },
        }
        return config;
    }

    static allImages(){
        let url = document.head.querySelector('meta[name="base-url"]').content;
        return {
            'logo' : url + '/public/front/images/logos_icons/logo_white.png',
            'intro' : url + '/public/front/images/intro-page/intro_bg.svg',
            'cars' :  {
                        'book1' : url + '/public/front/images/car-services-page/book1.png',
                        'book2' : url + '/public/front/images/car-services-page/book2.png',
                        'book3' : url + '/public/front/images/car-services-page/book3.png',
                        'book4' : url + '/public/front/images/car-services-page/book4.png',
                        'header' : url + '/public/front/images/car-services-page/bg-header.png'

            },
            'doctors' : {
                    'book1' : url + '/public/front/images/doctors-page/service-1.png',
                    'book2' : url + '/public/front/images/doctors-page/service-2.png',
                    'book3' : url + '/public/front/images/doctors-page/service-3.png',
                    'book4' : url + '/public/front/images/doctors-page/service-4.png',
                    'header' : url + '/public/front/images/doctors-page/bg-header.png'
            },
            'beuaty' : {
                    'book1' : url + '/public/front/images/beauty-centers-page/service-1.png',
                    'book2' : url + '/public/front/images/beauty-centers-page/service-2.png',
                    'book3' : url + '/public/front/images/beauty-centers-page/service-3.png',
                    'book4' : url + '/public/front/images/beauty-centers-page/service-4.png',
                    'header' : url + '/public/front/images/beauty-centers-page/bg-header.png'

            },
            'intro_page' : {
                    'book1' : url + '/public/front/images/intro-page/book1.png',
                    'book2' : url + '/public/front/images/intro-page/book2.png',
                    'book3' : url + '/public/front/images/intro-page/book3.png',
                    'book4' : url + '/public/front/images/intro-page/book4.png'
            },
            'loader' : url + '/public/front/images/doctors-list-view-page/loader.svg',
            'about' : {
                'logo' : url + '/public/front/images/about-page/logo-msa.png',
                'image' : url + '/public/front/images/about-page/image.png',

            },
            'contact' : url + '/public/front/images/about-page/logo-msa.png',
            'booked' : url + '/public/front/images/booked-successfully-page/check.svg'
        }
    }

    static getCssFile(fileName){
        var element = document.createElement("link");
        element.setAttribute("rel", "stylesheet");
        element.setAttribute("type", "text/css");
        element.setAttribute("id", "css-cust");
        element.setAttribute("href", rootUrl + "public/front/css/" + fileName + ".css");
        var el = document.getElementById('css-more').childNodes[0];
        document.getElementById("css-more").replaceChild(element, el);
    }

    static countNumberAnimation() {
        if ($('.views').is(':visible')) {
            let countRedy = true;
            function nowMakeCounter() {
                if ($(window).scrollTop() >= $('.views').offset().top - 300 && countRedy) {
                    countRedy = false;
                    $('.count').each(function () {
                        $(this).prop('Counter', 0).animate({
                            Counter: $(this).text()
                        }, {
                            duration: 4000,
                            easing: 'swing',
                            step: function (now) {
                                $(this).text(Math.ceil(now));
                            }
                        });
                    });
                }
            }
            nowMakeCounter();
            $(window).on('scroll', function () {
                nowMakeCounter();
            });
        }
    }



}
