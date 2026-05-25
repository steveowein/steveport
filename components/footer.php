</div> <!-- End main-wrapper -->

<footer class="footer-mega">
    <div class="footer-watermark">STEVE OWEIN</div>
    
    <div class="container footer-content">
        <div class="row g-5">
            <div class="col-lg-4">
                <h4 class="footer-title">STEVE.</h4>
                <p class="footer-text">
                    Information Systems Student and UI Designer. Focused on building high-performance, aesthetically exceptional digital experiences.
                </p>
                <div class="newsletter-form mt-4">
                    <input type="email" placeholder="Subscribe to newsletter">
                    <button type="submit"><i class="fas fa-arrow-right"></i></button>
                </div>
            </div>
            
            <div class="col-lg-2 offset-lg-1">
                <h4 class="footer-title" style="font-size: 1rem;">Navigation</h4>
                <ul class="footer-list">
                    <li><a href="<?= $base_url ?>/" class="footer-link">Home</a></li>
                    <li><a href="<?= $base_url ?>/about" class="footer-link">About</a></li>
                    <li><a href="<?= $base_url ?>/portfolio" class="footer-link">Portfolio</a></li>
                    <li><a href="<?= $base_url ?>/contact" class="footer-link">Contact</a></li>
                </ul>
            </div>
            
            <div class="col-lg-2">
                <h4 class="footer-title" style="font-size: 1rem;">Services</h4>
                <ul class="footer-list">
                    <li><a href="<?= $base_url ?>/services" class="footer-link">UI/UX Design</a></li>
                    <li><a href="<?= $base_url ?>/services" class="footer-link">Web Development</a></li>
                    <li><a href="<?= $base_url ?>/services" class="footer-link">Prototyping</a></li>
                </ul>
            </div>
            
            <div class="col-lg-3">
                <h4 class="footer-title" style="font-size: 1rem;">Contact</h4>
                <ul class="footer-list">
                    <li><a href="mailto:<?= htmlspecialchars($personal_info['email'] ?? '') ?>" class="footer-link"><i class="fas fa-envelope"></i> <?= htmlspecialchars($personal_info['email'] ?? 'Email Me') ?></a></li>
                    <li><a href="#" class="footer-link"><i class="fas fa-phone-alt"></i> <?= htmlspecialchars($personal_info['contact_number'] ?? 'Phone') ?></a></li>
                    <li><a href="#" class="footer-link"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($personal_info['address'] ?? 'Address') ?></a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div>
                &copy; <?= date('Y') ?> STEVE OWEIN. ALL RIGHTS RESERVED.
            </div>
            <div class="social-icons-footer">
                <a href="<?= htmlspecialchars($personal_info['linkedin'] ?? '#') ?>" target="_blank"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-github"></i></a>
                <a href="#"><i class="fab fa-figma"></i></a>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS for Header Scroll Effect -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const navbar = document.getElementById("mainNav");
        window.addEventListener("scroll", function() {
            if (window.scrollY > 50) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });
    });
</script>
</body>
</html>
