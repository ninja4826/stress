<!--<iframe src="http://www.staggeringbeauty.com/" style="border: 1px inset #ddd" width="498" height="598"></iframe>-->
<script>
    $(window).resize(function() {
        var header = $("body > header");
        var view_height = $(window).height() - header.height();
        var view_width = $(window).width();
        
        $("#stagger").attr("width", view_width.toString());
        $("#stagger").attr("height", view_height.toString());
    });
    $(document).ready(function() {
        $('<iframe />', {
            id: 'stagger',
            src: "http://www.staggeringbeauty.com/",
            style: "border: 1px inset #ddd"
        }).appendTo(".row");
        $(window).resize();
    });
</script>