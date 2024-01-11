<!-- footer and footer card-->
<a href="https://easymenu.site/" target="_blank"><p class="footer-copyright pb-3 mb-1 pt-0 mt-0 font-13 font-600"
                                                    style="color: {{(!isset($restaurant->id) or $restaurant->color == null) ? 'orange' : $restaurant->color->main_heads }} !important"
    >@lang('messages.made_love')
     
    </p></a>
