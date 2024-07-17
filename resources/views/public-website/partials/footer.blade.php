<footer class="footer">
    <div class="container">
        <h5>Follow us</h5>
        <div class="social-el">
            <ul class="social-btns">
                <li class="social-item">
                    <a class="social-link" href="{{ config('fantasy.social.instagram_url') }}" target="_blank">
                        <span class="fl fl-instagram"></span>
                    </a>
                </li>
                <li class="social-item">
                    <a class="social-link" href="{{ config('fantasy.social.twitter_url') }}" target="_blank">
                        <span class="fl fl-twitter"></span>
                    </a>
                </li>
                <li class="social-item">
                    <a class="social-link" href="{{ config('fantasy.social.facebook_url') }}" target="_blank">
                        <span class="fl fl-facebook"></span>
                    </a>
                </li>
            </ul>
        </div>
        <p class="text-center small">
            Copyright <?php echo date('Y'); ?> Fantasy League Limited. Fantasy League is a registered trademark of Fantasy League Limited.
        </p>
    </div>
</footer>
@include('partials.google_analytics')
@include('partials.facebook_pixel')
@include('partials.twitter_pixel')
