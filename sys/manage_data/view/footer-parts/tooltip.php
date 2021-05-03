<script>
    $(document).ready(function() {
        $(document.body).on('mouseover', '.help-tooltip', function() {
            obj=$(this);
            $('.tooltip-help-input').html(obj.attr('data-help'));
            $('.tooltip-help-input').css('display', 'block');
            $('.tooltip-help-input').css('top', obj.offset().top + 20);
            $('.tooltip-help-input').css('left', obj.offset().left - 85);
        });
        $(document.body).on('mouseout', '.help-tooltip', function() {
            obj=$(this);
            $('.tooltip-help-input').css('display', 'none');
        });
    });
</script>
<div class="tooltip-help-input">

</div>