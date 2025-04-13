<?php
include 'config.php';
include 'functions.php';
session_start();

$events = getEvents($pdo, 13); 
$categories = getCategories($pdo);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventHub - Book Amazing Events</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="#" class="logo">EventHub<span class="dot"></span></a>
                <ul class="nav-links">
                    <li><a href="#" class="nav-link">Home</a></li>
                    <li><a href="#" class="nav-link">Events</a></li>
                    <li><a href="#" class="nav-link">Categories</a></li>
                    <li><a href="#" class="nav-link">About</a></li>
                    <li><a href="#" class="nav-link">Contact</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="logout.php" class="btn btn-primary">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php" class="btn btn-primary">Login</a></li>
                        <li><a href="signup.php" class="btn btn-primary">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
                <button class="mobile-menu-btn">
                    <i class="fas fa-bars"></i>
                </button>
            </nav>
        </div>
    </header>

    <?php if (isset($_GET['booking'])): ?>
        <div class="container">
            <p class="<?php echo $_GET['booking'] === 'success' ? 'success-message' : 'error-message'; ?>">
                <?php echo $_GET['booking'] === 'success' ? 'Booking successful!' : 'Booking failed: ' . htmlspecialchars($_GET['message'] ?? 'Unknown error'); ?>
            </p>
        </div>
    <?php endif; ?>

    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Discover and Book Amazing Events Near You</h1>
                <p>Find the perfect events for your interests and hobbies. From concerts and workshops to sports and exhibitions - all in one place.</p>
                <form action="search.php" method="get" class="search-container">
                    <input type="text" name="search" class="search-input" placeholder="Search for events, categories or locations..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit" class="search-btn">Search</button>
                </form>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Featured Events</h2>
                <p class="section-subtitle">Discover a variety of events tailored to your interests.</p>
            </div>
            <div class="events-grid">
                <?php foreach ($events as $event): ?>
                    <div class="event-card">
                        <div class="event-image-container">
                            <img src="<?php echo htmlspecialchars($event['image_url']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>" class="event-image">
                            <div class="event-overlay">
                                <p class="event-overlay-text"><?php echo htmlspecialchars($event['description']); ?></p>
                            </div>
                        </div>
                        <div class="event-content">
                            <span class="event-date"><?php echo date('M d, Y', strtotime($event['date'])); ?></span>
                            <h3 class="event-title"><?php echo htmlspecialchars($event['title']); ?></h3>
                            <div class="event-location">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo htmlspecialchars($event['location']); ?></span>
                            </div>
                            <div class="event-details">
                                <span class="event-price">$<?php echo number_format($event['price'], 2); ?></span>
                                <a href="book.php?event_id=<?php echo $event['event_id']; ?>" class="btn btn-primary book-btn">Book Now</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>



    <section class="section categories-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Browse by Category</h2>
                <p class="section-subtitle">Find events that match your interests. We have something for everyone!</p>
            </div>
            <div class="categories-grid">
                <?php foreach ($categories as $category): ?>
                    <div class="category-card">
                        <i class="<?php echo htmlspecialchars($category['icon']); ?> category-icon"></i>
                        <h3 class="category-title"><?php echo htmlspecialchars($category['name']); ?></h3>
                        <p class="category-count">
                            <?php echo getEventCountByCategory($pdo, $category['category_id']) . ' Events'; ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>


    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">How It Works</h2>
                <p class="section-subtitle">Finding and booking events with EventHub is simple and easy.</p>
            </div>
            <div class="steps-container">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h3 class="step-title">Search Events</h3>
                    <p class="step-description">Browse through our extensive collection of events or search for specific ones that match your interests.</p>
                </div>

                <div class="step-card">
                    <div class="step-number">2</div>
                    <h3 class="step-title">Book Tickets</h3>
                    <p class="step-description">Select your event and book tickets securely in just a few clicks. Get instant confirmation.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h3 class="step-title">Enjoy the Event</h3>
                    <p class="step-description">Receive your tickets via email, show them at the venue, and enjoy your event!</p>
                </div>
            </div>
        </div>
    </section>
    <section class="section testimonials-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">What People Say</h2>
                <p class="section-subtitle">Don't just take our word for it. See what our users have to say about EventHub.</p>
            </div>
            <div class="testimonials-slider">
                <div class="testimonial">
                    <p class="testimonial-quote">
                        EventHub made finding and booking tickets to local events so easy! I discovered amazing concerts I would have missed otherwise. The interface is intuitive and the booking process was seamless.
                    </p>
                    <div class="testimonial-author">
                        <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBwgHBgkIBwgKCgkLDRYPDQwMDRsUFRAWIB0iIiAdHx8kKDQsJCYxJx8fLT0tMTU3Ojo6Iys/RD84QzQ5OjcBCgoKDQwNGg8PGjclHyU3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3N//AABEIAJQAlAMBIgACEQEDEQH/xAAcAAACAgMBAQAAAAAAAAAAAAAEBQMGAAIHAQj/xAA/EAACAQMDAQYEAQkFCQAAAAABAgMABBEFEiExBhMiQVFhMnGBkRQjQlKSobHB0eEWM2Jy8AcVJDREU2Nzgv/EABkBAAMBAQEAAAAAAAAAAAAAAAECAwAEBf/EACIRAAICAgMAAgMBAAAAAAAAAAABAhESIQMxQRNRMkJhIv/aAAwDAQACEQMRAD8ARx6RdzxbooenvQx0qfvzF3bGQdVFdRhhijsVC7elC2xgMkqptaQfERXI9BUTmVzp89scTRlTQ6FQCCOc10TWrOO5gO7J9BXO9Uja0lIYHBPFGLsVqg60haaUBDin4h2rljyBVa0bUY4ph3pxT+bUodnDDkUrTsNIim8VClCvPSsa7U8gio5J9w4OSfTzrYismWQeZreZd6eHkVKmhXndCa8lhs4zyO8bLkf5a0kudIswFlmuJT0LAqg/jRr6N8cmJ5oSGJwaCuIzuAxz1py2o6HNgLPcREnnvFDAfYip5LfSLkvb2d3udV3MzgKsh9vv0o79LQi6orcFx+HnQjyOatEesM8WSgPuKT3eliJx40I9VHFeQ2Un5hO3ypv8yJvTNLmQS3LsOpNE2SeMmhngaOVQykAnHNHW0ZRwTQYRsmBDkioPw7XJBwQpOKKtiHyG6U2Ea9yNqjFZUKKpNHjVsd2p968o+S9CttPUVlNZia8vxHagRsclfWq3Zz3bXZSJ2AJ6ij7eOSeM/o4wKYdnNO33MhIHhqSZrLPpunb7GIPyxGcmkHafshFcBpCx344AOBV+06JUiUZ4AqPUUR0JOKs4UrGT8Pnx9MubS5dWB2q2ASOteySyRrjOK6H2h0xNjzjABOeBXPtQiPfMAcihGWQr7IY7g8bjT6LUotDtY5VTvNRnBMKHGIh+kf5UksIGmu4YEUeJwGY/mjz/AGZqaKCTV9YnS3OPFh3P5oHRRWe2VgtWC3M13qNxvuDLcXBOd0hr2axitFPfEyTv0APhHrXQrDQILa1CRIN4Gcnzqp9otPkhl3KhZeT8qZSso46FYuLZMCO1ixjIJUE1FPeNMTnwnyxxignV0QSJ8H7qj7zd509ImMrbUHhkAlbeh4YHzFdM0S1gktY2jAKsu7PrXIt2PnV/7Easy2CxMR+TJUew6ilaSdiyGPaPT0jjMqqPDzVZjnDuMGrL2ivg1u+M8iqZbEiVfLJqc9giWC1yD504WUmIAkgULp0aMoz6U9hsEaFcg+LpU8WxWVqZm7w4PFZVik0dS3ArKbBmBtIgY23CkAimWggQX0ikdcU0trSOK2CqBwKVSSC21BWBwG4NBwxdmLnG6pFnFLr2dmBABwaji1BSEjZh6UYQrJkgEVa8kEp+vB5oWjHC9TXPdQt2juTnpnzrqWqd3uZeBzVN1e1V3JVck+gqCeLF9ENjEYra8uhuDQwsQc8ZIwPrzRnYBUihJlhffMxfvSBg1prTG37PyJjDTNj6AUT2Bhv5Ioy4UWowYwRzgH91MrcWzqjpIs95e3du4W0SLGOr5oO7iu7gB5kt5T+cIyQfsaN7RaMdTtiiSGI+q+1a6doQtnEjzy7cDwFyR+2jsfspetdn5U7ybT/hbl4z0qmyK0MhDKVxxtNdqvBGmdo8/M1zftBpzS3zLHg7icZHSmhPxizh6hFEwkAx1HIp92QlAvmgJxvGftXt7oUNvpImtdpkhJ3NnlsDJ/cftS+xk/D31vcKceIE49+DTOSlHROUGtMverRhoTg5wKqQ4l48jVmlL3C4GcEUIdHcKSEOSc1z5pCLQZpUxSFc9atFveqIUySWFVW2t5k47tjj0pnDZXLj+6cU2aRNsf8A+8Ij1ZfvWUpj0e4Zc7ayh8ptlkt7kSQgjzFItcVwe8XPBp/p0CJbx59Kh1aKMxsOOlWcbWwlWsNRnlxuPIPxVcILwtbqSSePKqJFNHBIyDyY0xt9U2HaG4rntroFheqCWe6Ug7VB+9S2lmkgJdQfShZb2ORd24ZFaQaxHECucUV3s1iL/aFa91Yxd2OAxHFOdDuorPs9ZSxx7l7hfh69KC16RdWsJoVwW2kqaX9k76d9GNtGsbyW8mCshxhT/o0VLR18SyoudheNcEsYZETGcSCibmTw8Ums59TcgzJbiMdSpINHyvkDNHLRWUMXTFl+x9aSWUBuLmRvDnB8RGcDNNNSkxlR51Xb1ZYrOebcy4GFwcUiG6QN2n1C2gsRptowa4ceMZztX3PqRVeh8UJB6igEG12duu7k0ap25YfCRmuqMaVHLKWTs6f2YSK+0y3lx4tuG+Y4qzw6fDgeAVz7sPqYiV7ZjwTvT+NXuPUQq56V5vInGTRPHYzisIF6Iv2qRo44x+bSh9ZRBneKR6n2hY5WHnPnRimxlFIsr3USMV3CsrnrXU8jFndsn3rKb42NRYrTtVb/AIdA0m1lGMYoPUu0n4hSsIOTxk1T49w61OpJrplNkcTd5HLk7jya3jlcDrWKgxzWyoM0l2CkjcTvWEsx5NbCMV7txQaZk4ontd6tkHAHWlrOND16O6wTZ3Bw+PLPXj24NMoa01q3W50uX9KPDLxQinGW/SseVfiixDW9PSAMLmEKRkHeKjbUVmwYm3A9COlcjuoVcE7RuX261dexM3faesbHPd8D2q3JClZaE7dFiETTN4vOgNbtN9o0eKfwRDbmvI7D8XKd65jU8+/tUopt6HlJJHHbqyngd+8jdY3Zu7ZhgMR6VtaHeuw10ztT2TXVe7eGbupYvgPUY9MelUHUdE1HSJy9xbsYv+5GNyn+Vdi6OW9mmn3jWM4YE+FqvS3zSW6OjEqy5FUCf8qokQjOPLzFWPs3ILiw7osd0R+4qHLBPZRdB0ly5fO4158XWiDbj2+9edwD6UtIUjAGKyphb+9ZWGFZgYDlalgtXc8DipZbuEnwkH3o7S7iEoelB6OUhNiVXxVottzxRd7covwmlZ1IRy+1BJsFB62rVt+EJ61HDqat1FeyaguOK1MFEywIvU1Hq7C200tj48gY9MdahsJXvr5LdWKhj4mx8I9aWdrrxfxX4aJiY4F2k+/n/r3opXJItxQ/ZlZK5H0qw9jH7iaWM9GIpERtjYnnC1c+yukw3Xc3MbuoYYkT5ehro5FcaKxdOy26dGbkDHCeZ9acpEiRgIMD2rSCNIo1WMADFTH4R+6hCNCTnkyFkBzUMltHIMMoIPkaN2+1alQPKnEKZrvYu0uA8liBBOecL8LfMVS7FZ9E1cwXaFGJ2keXPQ/KuwTN1qmdurFJ9P8AxiKO9t+cjzXz+3WlbvQ0WCs7Z+EViyv7UDptyLq0VjkuvDAURkDorfY1H+FAoSv7VlD7v/G9e0KBYntYXkXiN/1TTO3tJ0XKxSfqmjodVtFPGTj2rxtehR+ImP0pm2xVFIGfS7+fpE4z68VEvZy97zlPuRTIdplGMQOaxu1BxxanPuaCTRsYm1t2alI/KNt+WKJj7JiX4p2QZ65FDxdo7p+IrdPq1NLS/mnYL3fd5Hids4+lLJtFIwTPLm2s9B0yV7fBIXJc/E5/gK5hfF5pSWOSxLMT71b+0+qJOPwkG5okPikz8TefHpVJu5GlkZI84B+/zqnDH0bkaSxR5dse5ijj5LtXRuxKotnBsdSWzuwPP51zm8xGyKv5owD+j6107shbPbaJaD85huweozVJdEi1RDjNTryM4rxEwBWxOBgCmENW+ZHyqGRsdWP1NbSM3ov3oeR36bgB/hFI2ZEczYHNKdQQTwyRPyrqVI9c0bK3zockLulcZWNd318qm3sY552XvU03VjFcAGAuY33eXPBroRn0xTy9uPqK5Hduy3103I3SMR981aNFU6xbhhKqyx+FgfMeRppr0ddFyN1pef7yD7ispGNBbHMyZrKQAPb6CqnxTn6Cjx2atsBjcSH24pIINWPIiuif/WanW31iQj8nc49DkVjDp+z9oIsrJJn5j+VCJotuG8Uj/XFDLp+sk7Vhmx/n/rW7aHq3V1kH/wBc1gh5063jt5ljch2QgE81XZO1Uw/4WVSmEwSozlwf3U2j0DVEIbumOOfiqm64IVkkUxvFcK53RuOnvmjGCb2MptImmvklBAjaN2z18/eg0Uopfguef5UJGWAAyT71ZeyfZm51zE0++KwU8uBgyewz++rpUI2Jbe3e8u+7ijkkZmA8Kk/PpXZ9HtWWJWlTZtGFT296906xtNNtxBZRJHGB+b5/M+dFhuclqzoXLVBHPlUbE+hqJ3X9L9tQO3ozfelbAkEOGP8AU0FPKoyFYMR1x5VFM4HxEn5mhJZckKPoBUpSGSNpJM58QAHU+VC3rsbVyFzGq7tv6R96MW15DSDJ6geQr25jDRlT5ik32E4/N3txLJhNzOxbCjpmjezV1LZXjIG2s67Tx9a9MT2mu3FqrEAvtyMZxnPn86daHocU19JO0hWFTxk8n69Ks5KhkvTc6pfZPj/ZWU5bR7LP98f1xXtT0YjPbIY/5ZR795/SoR2yI+GFM+5NVyGxy3XOOtEx2CMelPiLY9/tnIekUWfrXv8AbCc8usQ+h/nSCSzWM8daZaH2fuNXmAijPdqfG56L/WhRrH+h69farqCQxwoYlO6VscKvzzR+vdn49cIaSCLwjHeMNu36/wAKYadpun6Gr/h0LTMAsgaQkHHr9/KvLm7kkPibwjoo6CjdBjFtiDTOxmiWsgFypu585UycRj22+f1qw7CiiJAEjUYVV4AHy8qV3ExwcHBHT2o7Tr0XsZDECePhvf3oxnemHkg1tE3dnyzWCE+prfNaNMFHWjojs97kAeJsUNcXEcSkLyfWobi5d/CvSh0iJOWOT71OUvooo/ZEZZZz4ePcj+FEwW+3xdT5k+dTRQqfh61My7FGetIl9mbPJMhV2+lCzs3mPKiXztHBoaVmwcbuB5ZpmBHLtVjkk7QXcsWJQJOdo9hx86Y3N5PFs2o+Aoz86eDSLzvZXSKMb3Lct6msOgX0nLCP9am7DehIk95IoYIcGsq0Q6NdJGFLRfrVlCkYNsNEsLm67qSHAz1B5pzc9ndLtCI0tg3+J2OaysosdHq6Xp0IVlsYC3q67v30TdSNH+SjwiAA4UYrKygh0kAMfyYNBzscdayspZDIWXDtg80HaXMsGpQPG2CXVT7gmvKykXYX0XG4JA4oJiWbBNZWVVnMjZACDnyrwCsrKQYmXgDFTRnfhW5ArKynQjPREpLcsMehoeSJckZb9Y1lZRfQCn31/dRXUqRzMFViAM0LLql6P+ok+9ZWVkY0GoXZGTcSfrGsrKyiY//Z" alt="Sarah-Johnson" class="author-image">
                        <div class="author-info">
                            <h4>Sarah Johnson</h4>
                            <p>Music Enthusiast</p>
                        </div>
                    </div>
                </div>
                <div class="slider-controls">
                    <span class="slider-dot active"></span>
                    <span class="slider-dot"></span>
                    <span class="slider-dot"></span>
                </div>
            </div>
        </div>
    </section>

    <section class="section newsletter-section">
        <div class="container">
            <div class="newsletter-container">
                <h2 class="newsletter-title">Stay Updated</h2>
                <p class="newsletter-description">Subscribe to our newsletter and be the first to know about upcoming events, exclusive offers, and discounts.</p>
                <form class="newsletter-form">
                    <input type="email" class="newsletter-input" placeholder="Enter your email address">
                    <button type="submit" class="newsletter-btn">Subscribe</button>
                </form>
                <p class="newsletter-privacy">We respect your privacy. Unsubscribe at any time.</p>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column footer-about">
                    <h3>About EventHub</h3>
                    <p>EventHub is the leading platform for discovering and booking events across all categories. Our mission is to connect people with experiences they'll love.</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Events</a></li>
                        <li><a href="#">Categories</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Support</h3>
                    <ul class="footer-links">
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Refund Policy</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Contact Us</h3>
                    <ul class="contact-info">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Lovely Professional University, Phagwara, Punjab 144411</span>
                        </li>
                        <li>
                            <i class="fas fa-phone-alt"></i>
                            <span>+91 7903818511</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>prince.12320812@lpu.in</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p class="copyright">&copy; 2025 EventHub. All rights reserved.</p>
                <div class="footer-nav">
                    <a href="#">Terms</a>
                    <a href="#">Privacy</a>
                    <a href="#">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            const navLinks = document.querySelector('.nav-links');

            mobileMenuBtn.addEventListener('click', function() {
                navLinks.classList.toggle('active');

                const icon = mobileMenuBtn.querySelector('i');
                if (navLinks.classList.contains('active')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });

            document.addEventListener('click', function(event) {
                if (!event.target.closest('.mobile-menu-btn') &&
                    !event.target.closest('.nav-links') &&
                    navLinks.classList.contains('active')) {
                    navLinks.classList.remove('active');
                    const icon = mobileMenuBtn.querySelector('i');
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const dots = document.querySelectorAll('.slider-dot');

            dots.forEach(dot => {
                dot.addEventListener('click', function() {
                    dots.forEach(d => d.classList.remove('active'));
                    this.classList.add('active');

                });
            });
        });
    </script>
</body>

</html>