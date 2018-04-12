/* 
 Document   : image_map
 Created on : 21 Jun 13, 19:14:52
 Author     : Arfan Fudyartanto D N <arfan@mylits.com>, <arfan@gamatechno.com>
 */

//core
var mousedown_time = 0;
var mousehold = false;
var act_helper = '';
//core
$(document).ready(function() {
    //setting up mousehold
    var interval;
    //setting up mousehold
    $("body").mousedown(function() {
        mousehold = true;
        interval = setInterval(function() {
            mousedown_time++;
        }, 100);
    }).bind('mouseup', function() {
        if (mousedown_time > 1) {
            setTimeout(function() {
                mousehold = false;
            }, 1000);
        } else {
            mousehold = false;
        }
        mousedown_time = 0;
        clearInterval(interval);
    });
});

/* -- obj definition -- */

/* -- map object -- */
function ImageMap() {
    this.x = 0;
    this.y = 0;
    this.container;
    this.canvas;
    this.setUp = setUp;
    this.img;
    this.ctx;
    this.offset = 0;
    this.addEventListener = addEventListener;
    this.location;
    this.getLocation = getLocation;
    this.clear = clear;
    function setUp(container) {
        this.container = $('#' + container);

        this.container.css({
            "position": "relative",
            "overflow": "visible"
        });
        var temp_top = 0;
        var temp_left = 0;
        var map = this;
        this.container.draggable({
            start: function() {
                temp_top = $(this).position().top - map.y;
                temp_left = $(this).position().left - map.x;
            },
            drag: function() {
                mousehold = true;
                map.y = (temp_top + $(this).position().top);
                map.x = (temp_left + $(this).position().left);
                $("#map_x").val(map.x);
                $("#map_y").val(map.y);
            },
            stop: function() {
                $("#map_x").val(map.x);
                $("#map_y").val(map.y);
                setTimeout(function() {
                    mousehold = false;
                }, 1000);
            }
        });
        var date = new Date();
        var time = date.getTime();
        this.container.append("<canvas class='img-map-canvas' id='drawer_" + time + "'></canvas>");
        this.canvas = $("#drawer_" + time);
        this.canvas.css({
            "position": "absolute",
            "top": "0px",
            "left": "0px"
        });
        if (this.container.find("img").length >= 1) {
            this.img = this.container.find("img");
            
            this.img.css({
                "max-width": "none",
                "width": "auto",
                "height": "auto",
                "z-index": "-10"
            });
            var canvas = document.getElementById('drawer_' + time);
            canvas.width = this.img.width();
            canvas.height = this.img.height();
            this.ctx = canvas.getContext('2d');
            this.container.scrollTop(0);
            this.container.scrollLeft(0);
            this.offset = this.img.offset();
        }
    }

    function clear() {
        this.ctx.clearRect(0, 0, this.img.width(), this.img.height());
    }

    function getLocation(event) {
        var window_x = event.pageX;
        var window_y = event.pageY;
        var scrol_top = this.container.scrollTop();
        var scrol_left = this.container.scrollLeft();
        var coor = new Object();
        coor.x = window_x - this.offset.left + scrol_left - this.x;
        coor.y = window_y - this.offset.top + scrol_top - this.y;
        return coor;
    }

    function addEventListener(type, act) {
        if (type == 'click') {
            this.canvas.click(eval(act));
        }
    }
}

/* -- marker object -- */
function marker() {
    this.x = 0;
    this.y = 0;
    this.position = setPosition;
    this.img;
    this.element;
    this.updatePosition = updatePosition;
    this.setImage = setImage;
    this.draw = draw;
    this.draggable = setDraggable;
    this.addEventListener = addEventListener;
    this.detach = detach;
    this.id;

    function setImage(img_path) {
        this.img = img_path;
    }

    function setPosition(x, y) {
        this.x = x;
        this.y = y;
    }

    function draw(map) {
        var date = new Date();
        var time = date.getTime();
        map.container.append('<img class="marker" id="marker_' + time + '" src="' + this.img + '"/>');
        this.element = $("#marker_" + time);
        this.element.css({
            "position": "absolute",
            "top": (this.y - (this.element.height() / 2)) + "px",
            "left": (this.x - (this.element.width() / 2)) + "px",
            "z-index": 10
        });
    }

    function setDraggable(act) {
        this.element.draggable(eval(act));
    }

    function addEventListener(type, act) {
        if (type == 'dblclick') {
            this.element.dblclick(eval(act));
        }
    }

    function detach() {
        this.element.detach();
        this.x = null;
        this.y = null;
    }

    function updatePosition() {
        this.y = parseInt(this.element.css("top").split("px")[0]) + (this.element.outerHeight() / 2);
        this.x = parseInt(this.element.css("left").split("px")[0]) + (this.element.outerWidth() / 2);
    }
}

/* -- polygon object -- */
function polygon(map) {
    this.id;
    this.ctx;
    this.path = new Array();
    this.set_path = set_path;
    this.draw = draw;
    this.getJsonPath = getJsonPath;
    this.fillStyle = "rgba(0, 0, 200, 0.5)";
    this.setFillColor = setFillColor;
    this.addEventListener = addEventListener;
    this.map = map;
    this.isInside = isInside;
    this.element;
    this.detach = detach;
    this.max_x;
    this.max_y;
    this.min_x;
    this.min_y;
    this.ballon;
    this.setBallon = setBallon;
    this.setClassBallon = setClassBallon;
    this.setColor = setColor;
    this.redraw = redraw;

    function set_path(path) {
        var tmp = new Array();
        var arr_x = new Array();
        var arr_y = new Array();
        $.each(path, function(index, val) {
            arr_x.push(val.x);
            arr_y.push(val.y);
            if ((val.x != null) || (val.y != null)) {
                tmp.push(val);
            }
        });
        arr_x.sort(function(a, b) {
            return a - b
        });
        arr_y.sort(function(a, b) {
            return a - b
        });
        this.min_x = arr_x[0];
        this.max_x = arr_x[(arr_x.length - 1)];
        this.min_y = arr_y[0];
        this.max_y = arr_y[(arr_y.length - 1)];
//        alert(arr_x.toString() + " | " + arr_y.toString() + " , min_x: " + this.min_x + " , max_x: " + this.max_x + " , min_y: " + this.min_y + " , max_y: " + this.max_y);

        this.path = tmp;
    }

    function setFillColor(color) {
        this.fillStyle = color;
    }

    function draw() {
        //var ctx 
        /*
         * Try to add canvas for layering
        var date = new Date();
        var time = date.getTime();
        this.map.container.append("<canvas class='polygon_canvas' id='polygon_" + time + "'></canvas>");
        var jcanvas = $("#polygon_" + time);
        jcanvas.css({
            "position": "absolute",
            "top": "0px",
            "left": "0px",
            "z-index": 0
        });
        var canvas = document.getElementById('polygon_' + time);
        canvas.width = this.map.img.width();
        canvas.height = this.map.img.height();
        this.ctx = canvas.getContext('2d');
        var ctx = canvas.getContext('2d');*/
        var ctx = this.map.ctx;
        if (this.path.length > 2) {
            ctx.beginPath();
            ctx.fillStyle = this.fillStyle;
            $.each(this.path, function(index, obj) {
                if ((obj.x != null) || (obj.y != null)) {
                    if (index == 0) {
                        ctx.moveTo(obj.x, obj.y);
                    } else {
                        ctx.lineTo(obj.x, obj.y);
                    }
                }
            });
            ctx.fill();
        }
    }

    function redraw() {
        /*
         * Still under contructions
         * var ctx = this.ctx;
        alert(this.map.img.width());
        //ctx.clearRect(0, 0, this.map.img.width(), this.map.img.height());
        ctx.beginPath();
        ctx.fillStyle = this.fillStyle;
        //ctx.globalCompositeOperation = 'destination-atop';
        $.each(this.path, function(index, obj) {
            if ((obj.x != null) || (obj.y != null)) {
                if (index == 0) {
                    ctx.moveTo(obj.x, obj.y);
                } else {
                    ctx.lineTo(obj.x, obj.y);
                }
            }
        });
        ctx.fill();*/
    }

    function setColor(color) {
        if ($.trim(color) != "") {
            var RGB = image_map_hex_to_rgb(color);
            this.fillStyle = "rgba(" + RGB + ", 0.7)";
        }
    }

    function setBallon(str) {
        var date = new Date();
        var time = date.getTime();
        this.map.container.append("<div id='polygon_baloon_" + time + "'>" + str + "</div>");
        this.ballon = $("#polygon_baloon_" + time);
        var plg = this;
        this.ballon.css({
            "position": "absolute",
            "top": plg.min_y + "px",
            "left": plg.min_x + "px",
            "display": "none"
        });
    }

    function setClassBallon(ballonclass) {
        this.ballon.addClass(ballonclass);
    }

    function detach() {
        if (this.element != null) {
            this.element.detach();
            this.id = null;
            this.ctx = null;
            this.path = null;
            this.fillStyle = null;
            this.map = null;
            this.element = null;
            this.max_x = null;
            this.max_y = null;
            this.min_x = null;
            this.min_y = null;
            this.ballon = null;
        }
    }

    function addEventListener(type, act) {
        var loc;
        var map = this.map;
        var plg = this;
        if (type == 'click') {
            this.map.canvas.click(function(event) {
                loc = map.getLocation(event);
                if (plg.isInside(loc)) {
                    alert("test");
                }
            });
        } else if (type == 'hover') {
            this.map.canvas.mousemove(function(event) {
                loc = map.getLocation(event);
                $("#map_y").val("min_y: " + plg.min_y + " , max_y: " + plg.max_y + "\nloc_y: " + loc.y);
                $("#map_x").val("min_x: " + plg.min_x + " , max_x: " + plg.max_x + "\nloc_x: " + loc.x);
                if ((loc.y >= plg.min_y) && (loc.y <= plg.max_y) && (loc.x >= plg.min_x) && (loc.x <= plg.max_x)) {
                    if (plg.isInside(loc)) {
                        if (act == 'show_ballon') {
                            plg.ballon.stop(true, true).fadeIn();
                            plg.ballon.css({
                                "top": (loc.y + 15) + "px",
                                "left": (loc.x + 15) + "px"
                            });
                        }
                    } else {
                        if (act == 'show_ballon') {
                            plg.ballon.stop(true, true).fadeOut();
                        }
                    }
                } else {
                    if (act == 'show_ballon') {
                        plg.ballon.stop(true, true).fadeOut();
                    }
                }
            });
        }
    }

    function isInside(loc) {
        if (this.path.length > 2) {
            var go_in = false;
            var m = 0;
            var next = 0;
            var path = this.path;
            var length = path.length;
            var log_cros = new Array();
            var inside = false;
            var y = loc.y;
            var x = 0;
            var temp_x;
            var temp_y;


            $.each(path, function(index, marker) {
                if (index < (length - 1)) {
                    next = index + 1;
                } else if (index == (length - 1)) {
                    next = 0;
                }
                if (index <= (length - 1)) {
                    if (((path[index].y < loc.y) && (path[next].y > loc.y) || (path[index].y > loc.y) && (path[next].y < loc.y))) {
                        m = (path[index].y - path[next].y) / (path[index].x - path[next].x);
                        x = (y - path[index].y + (m * path[index].x)) / m;

                        temp_y = y;
                        temp_x = x;
                        log_cros.push(temp_x);
                    }
                }

            });
            log_cros.sort(function(a, b) {
                return a - b
            });

            $.each(log_cros, function(index, val_x) {
                if (go_in) {
                    if (((loc.x >= temp_x) && (loc.x <= val_x)) || (((loc.x <= temp_x) && (loc.x >= val_x)))) {
                        inside = true;
                    }
                }
                temp_x = val_x;
                go_in = !go_in;
            });
            return inside;
        }
    }

    function getJsonPath() {
        var num_point = this.path.length;
        if (num_point > 2) {
            var separator = '';
            var STR_JSON = '{"coordinate" : [';
            $.each(this.path, function(index, val) {
                if ((val.x != null) || (val.y != null)) {
                    if (index == (num_point - 1)) {
                        separator = '';
                    } else {
                        separator = ', ';
                    }
                    STR_JSON += '{"x":' + val.x + ',"y":' + val.y + '}' + separator;
                }
            });
            STR_JSON += ']}';
            return STR_JSON;
        }
    }
}

function image_map_hex_to_rgb(sd) {
    if (isHexNum(sd) && sd.length < 7) {
        sd = sd.toLowerCase();
        if (sd.length == 6) {
            var sdx = sd.substring(0, 2);
            var result = hexToDeci(sdx)

            sdx = sd.substring(2, 4);
            result = result + ", " + hexToDeci(sdx)

            sdx = sd.substring(4, 6);
            result = result + ", " + hexToDeci(sdx)

            return result;
        } else {
            return '';
        }
    } else {
        return  sd.substring(0, sd.length - 1);
    }
}

function isHexNum(num) {
    args = num;
    sdsf = args.substring(args.length - 1, args.length);
    //document.third.hexBin.value = sdsf;
    lc = sdsf.toLowerCase()
    if (isNum(sdsf) || lc == 'a' || lc == 'b' || lc == 'c' || lc == 'd' || lc == 'e' || lc == 'f')
    {
        return true;
    }
    return false;
}


function hexToDeci(num) {
    res4 = 999;
    args = num;

    k = args.length - 1;
    for (var i = 0; i < args.length; i++)
    {
        thisnum = args.substring(i, i + 1);
        var resd = Math.pow(16, k);
        if (thisnum == 'a')
            thisnum = 10;
        else if (thisnum == 'b')
            thisnum = 11;
        else if (thisnum == 'c')
            thisnum = 12;
        else if (thisnum == 'd')
            thisnum = 13;
        else if (thisnum == 'e')
            thisnum = 14;
        else if (thisnum == 'f')
            thisnum = 15;
        resd = resd * thisnum;
        k = k - 1;
        if (res4 == 999)
        {
            res4 = resd.toString();
        }
        else
        {
            res4 = parseInt(res4) + parseInt(resd);
        }
    }

    return res4;
}


function isNum(args) {
    args = args.toString();

    if (args.length == 0)
        return false;

    for (var i = 0; i < args.length; i++) {
        if (args.substring(i, i + 1) < "0" || args.substring(i, i + 1) > "9") {
            return false;
        }
    }

    return true;

}