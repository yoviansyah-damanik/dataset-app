<script type="text/php">
    if ( isset($pdf) ) {
        $x = 30;
        $x_2 = 540;
        $x_3 = 450;
        $y = 815;

        $text = "Diakses melalui {{ url('/') }} | {{ GeneralHelper::get_app_name() }} | {{ $created_at }}";
        $text_2 = "{PAGE_NUM} / {PAGE_COUNT}";
        $text_3 = "{{ $unique_code }}";
        $font = $fontMetrics->get_font("serif");
        $size = 8;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        $pdf->page_text($x_2, $y, $text_2, $font, $size, $color, $word_space, $char_space, $angle);
        $pdf->page_text($x_3, $y, $text_3, $font, $size, $color, $word_space, $char_space, $angle);
    }
</script>
