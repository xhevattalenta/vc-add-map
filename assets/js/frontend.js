var truckpress = truckpress || {},
    truckpressShortCode = truckpressShortCode || {};

jQuery(document).ready(function ($) {
    'use strict';

    // Counter
    function count($this) {
        var current = parseInt($this.html(), 10);
        current = current + 10;
        $this.html(++current);
        if (current > $this.data('count')) {
            $this.html($this.data('count'));
        }
        else {
            setTimeout(function () {
                count($this);
            }, 5);
        }
    }

    $('.stat-count').each(function () {
        $(this).data('count', parseInt($(this).html(), 10));
        $(this).html('0');
        count($(this));
    });

    // Truck Shipment
    $('.tp-shipment').on('click', '.ts-truck-numbers', function (e) {
        e.preventDefault();
        var numbers = $(this).parents('.tp-shipment').find('.ts-numbers').val(),
            $results = $(this).parents('.tp-shipment').find('.tp-truck-results'),
            $parent = $(this).parents('.shipment-detail'),
            s_number = '';
        $parent.addClass('loading');

        numbers = numbers.split('\n');
        for (var i = 0; i < numbers.length; i++) {
            s_number += '|' + numbers[i];
        }

        $.ajax({
            url: truckpress.ajax_url,
            dataType: 'json',
            method: 'post',
            data: {
                action: 'truck_results',
                tpnonce: truckpress.nonce,
                numbers: s_number
            },

            success: function( response ) {
                window.console.log(response);
                $results.html( response.data );
                $parent.removeClass('loading');

            }
        });
    });

    // Truck Reference
    $('.tp-shipment').on('click', '.ts-truck-reference', function (e) {
        e.preventDefault();
        var mode = $(this).parents('.tp-shipment').find('.select-mode').val(),
            $parent = $(this).parents('.reference'),
            ref = $(this).parents('.tp-shipment').find('.txt-reference').val(),
            location = $(this).parents('.tp-shipment').find('.order-location').val(),
            b_day = $(this).parents('.tp-shipment').find('.ts-between .order-days').val(),
            b_month = $(this).parents('.tp-shipment').find('.ts-between .order-months').val(),
            b_year = $(this).parents('.tp-shipment').find('.ts-between .order-years').val(),
            t_day = $(this).parents('.tp-shipment').find('.ts-and .order-days').val(),
            t_month = $(this).parents('.tp-shipment').find('.ts-and .order-months').val(),
            t_year = $(this).parents('.tp-shipment').find('.ts-and .order-years').val(),
            $results = $(this).parents('.tp-shipment').find('.tp-truck-results');

        $parent.addClass('loading');

        $.ajax({
            url: truckpress.ajax_url,
            dataType: 'json',
            method: 'post',
            data: {
                action: 'truck_results',
                tpnonce: truckpress.nonce,
                mode: mode,
                ref: ref,
                location: location,
                between: b_year + '-' + b_month + '-' + b_day,
                and:  t_year + '-' + t_month + '-' + t_day
            },
            success: function (response) {
                $results.html(response.data);
                $parent.removeClass('loading');
            }
        });
    });

    truckpressMaps();

    testimonialCarousel();

    postsCarousel();

    postsCarousel2();


    /**
     * Init testimonials carousel
     */
    function testimonialCarousel() {
        if (truckpressShortCode.length === 0 || typeof truckpressShortCode.testimonial === 'undefined') {
            return;
        }
        $.each(truckpressShortCode.testimonial, function (id, testimonialData) {
            $(document.getElementById(id)).owlCarousel({
                items: testimonialData.columns,
                navigation: false,
                transitionStyle : 'fade',
                autoPlay: testimonialData.autoplay,
                pagination: testimonialData.pagination,
                itemsTablet: [768, 1],
                itemsDesktopSmall: [979, 1],
                itemsDesktop: [1199, 1],
                slideSpeed : 800,
                paginationSpeed : 1000

            });
        });
    }


    /**
     * Init testimonials carousel
     */
    function postsCarousel() {
        if (truckpressShortCode.length === 0 || typeof truckpressShortCode.postsCarousel === 'undefined') {
            return;
        }
        $.each(truckpressShortCode.postsCarousel, function (id, postsData) {
            $(document.getElementById(id)).owlCarousel({
                singleItem: true,
                navigation: postsData.navigation,
                autoPlay: postsData.autoplay,
                pagination: false,
                navigationText: ['<span class="fa fa-caret-left"></span>', '<span class="fa fa-caret-right"></span>'],
                itemsTablet: [768, 1],
                itemsDesktopSmall: [979, 1],
                itemsDesktop: [1199, 1],
                slideSpeed : 800,
                paginationSpeed : 1000
            });
        });
    }

    /**
     * Init testimonials carousel
     */
    function postsCarousel2() {
        if (truckpressShortCode.length === 0 || typeof truckpressShortCode.postsCarousel2 === 'undefined') {
            return;
        }
        $.each(truckpressShortCode.postsCarousel2, function (id, postsData) {
            $(document.getElementById(id)).owlCarousel({
                singleItem: false,
                items: 2,
                navigation: postsData.navigation,
                autoPlay: postsData.autoplay,
                pagination: false,
                navigationText: ['<span class="fa fa-caret-left"></span>', '<span class="fa fa-caret-right"></span>'],
                itemsTablet: [768, 1],
                itemsDesktopSmall: [979, 2],
                itemsDesktop: [1199, 2],
                slideSpeed : 800,
                paginationSpeed : 1000
            });
        });
    }

    /**
     * Init Google maps
     */
    function truckpressMaps() {
        if (truckpressShortCode.length === 0 || typeof truckpressShortCode.map === 'undefined') {
            return;
        }


        var mapOptions = {
            scrollwheel: false,
            draggable: true,
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            panControl: false,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL
            },
            scaleControl: false,
            streetViewControl: false

        };

        var bounds = new google.maps.LatLngBounds();
        var infoWindow = new google.maps.InfoWindow(), marker, i, map;


        $.each(truckpressShortCode.map, function (id, mapData) {

            var styles = [
                    {
                        'featureType': 'administrative',
                        'elementType': 'labels.text.fill',
                        'stylers': [
                            {
                                'color': '#444444'
                            }
                        ]
                    },
                    {
                        'featureType': 'landscape',
                        'elementType': 'all',
                        'stylers': [
                            {
                                'color': '#f2f2f2'
                            }
                        ]
                    },
                    {
                        'featureType': 'poi',
                        'elementType': 'all',
                        'stylers': [
                            {
                                'visibility': 'off'
                            }
                        ]
                    },
                    {
                        'featureType': 'road',
                        'elementType': 'all',
                        'stylers': [
                            {
                                'saturation': -100
                            },
                            {
                                'lightness': 45
                            }
                        ]
                    },
                    {
                        'featureType': 'road.highway',
                        'elementType': 'all',
                        'stylers': [
                            {
                                'visibility': 'simplified'
                            }
                        ]
                    },
                    {
                        'featureType': 'road.arterial',
                        'elementType': 'labels.icon',
                        'stylers': [
                            {
                                'visibility': 'off'
                            }
                        ]
                    },
                    {
                        'featureType': 'transit',
                        'elementType': 'all',
                        'stylers': [
                            {
                                'visibility': 'off'
                            }
                        ]
                    },
                    {
                        'featureType': 'water',
                        'elementType': 'all',
                        'stylers': [
                            {
                                'color': mapData.bg_color
                            },
                            {
                                'visibility': 'on'
                            }
                        ]
                    }
                ],
                customMap = new google.maps.StyledMapType(styles,
                    {name: 'Styled Map'});

            // Display a map on the page
            mapOptions.zoom = parseInt(mapData.zoom, 10);
            mapOptions.mapTypeControlOptions = {
                mapTypeIds: [google.maps.MapTypeId.ROADMAP]
            };

            map = new google.maps.Map(document.getElementById(id), mapOptions);
            map.mapTypes.set('map_style', customMap);
            map.setMapTypeId('map_style');
            for (i = 0; i < mapData.number; i++) {
                var lats = mapData.lat,
                    lng = mapData.lng,
                    info = mapData.info;

                var position = new google.maps.LatLng(lats[i], lng[i]);
                bounds.extend(position);

                // Create marker options
                var markerOptions = {
                    map: map,
                    position: position
                };
                if (mapData.marker) {
                    markerOptions.icon = {
                        url: mapData.marker
                    };
                }

                // Init marker
                marker = new google.maps.Marker(markerOptions);

                // Allow each marker to have an info window
                googleMaps(infoWindow, map, marker, info[i]);

                // Automatically center the map fitting all markers on the screen
                map.fitBounds(bounds);
            }

        });
    }

    function googleMaps(infoWindow, map, marker, info) {
        google.maps.event.addListener(marker, 'click', function () {
            infoWindow.setContent(info);
            infoWindow.open(map, marker);
        });
    }

});