<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">Department of Defence</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarNav">
        <ul class="navbar-nav ms-auto fw-bolder text-white  ">
            <?php if (isset($_SESSION['username'])): ?>
                <li class="nav-item mx-3">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link" href="create_buzzer.php">Create Buzzer</a>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link" href="start_buzzer.php">Start Buzzer</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Messages
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-dark  " aria-labelledby="navbarDropdown">
                        <li class="nav-item mx-3">
                            <a class="nav-link" href="send_message.php">Send Message</a>
                        </li>
                        <li class="nav-item mx-3">
                            <a class="nav-link" href="read_message.php">Read Message</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            <?php else: ?>
                <li class="nav-item mx-3">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
