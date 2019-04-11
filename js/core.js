$(document).ready(function () {

    if ($.fn.revolution) {
        revapi = $('#home').revolution(
            {
                delay: 15000,
                startwidth: 1170,
                startheight: 500,
                hideThumbs: 10,
                fullWidth: "off",
                fullScreen: "on",
                navigationType: "none",
                fullScreenOffsetContainer: "",
                touchenabled: "on",
                videoJsPath: "assets/plugins/rs-plugin/videojs/"
            });

    }
})