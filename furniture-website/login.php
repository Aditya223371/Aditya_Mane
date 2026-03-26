<?php
if (session_status() === PHP_SESSION_NONE) session_start();
define('SITE_NAME', 'MANE FURNITURE');
define('SITE_TAGLINE', 'Premium Furniture');
$page_title = 'Sign In';

if (!empty($_SESSION['user'])) {
    header('Location: /furniture-website/my-account.php'); exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        $error = 'Please enter your email and password.';
    } else {
        // Try DB login first
        $db_ok = false;
        $config_path = __DIR__ . '/config/db.php';
        if (file_exists($config_path)) {
            try {
                require_once $config_path;
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND status = 'active' LIMIT 1");
                $stmt->execute([$email]);
                $user = $stmt->fetch();
                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user'] = [
                        'id'         => $user['id'],
                        'name'       => $user['first_name'] . ' ' . $user['last_name'],
                        'first_name' => $user['first_name'],
                        'email'      => $user['email'],
                        'role'       => $user['role'],
                    ];
                    $pdo->prepare("UPDATE users SET last_login=NOW() WHERE id=?")->execute([$user['id']]);
                    $db_ok = true;
                    $redirect = ($user['role'] === 'admin') ? '/furniture-website/admin/dashboard.php' : '/furniture-website/my-account.php';
                    header('Location: ' . $redirect); exit;
                }
            } catch (Exception $e) { /* DB not available */ }
        }
        if (!$db_ok) $error = 'Invalid email or password. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Sign In — MANE FURNITURE</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
:root{--cream:#F5F0E8;--brown:#2C1810;--gold:#C4942A;--white:#fff;--off-white:#FAF8F4;--border:#DDD3C0;--text:#1A0F0A;--text-mid:#4A3728;--text-light:#8B7355;--radius:6px;--font-serif:'Cormorant Garamond',Georgia,serif;--font-sans:'Jost',sans-serif;--transition:.25s ease}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:var(--font-sans);font-weight:300;background:var(--off-white);min-height:100vh;display:flex;flex-direction:column}
a{color:inherit;text-decoration:none}

/* TOP STRIP */
.auth-topstrip{background:var(--brown);color:var(--cream);text-align:center;padding:.5rem;font-size:.75rem;letter-spacing:.08em}
.auth-topstrip a{color:var(--gold);margin-left:.5rem}

/* LAYOUT */
.auth-wrap{flex:1;display:grid;grid-template-columns:1fr 1fr;min-height:calc(100vh - 40px)}

/* LEFT IMAGE PANEL */
.auth-left{position:relative;overflow:hidden}
.auth-left img{width:100%;height:100%;object-fit:cover}
.auth-left-overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(26,15,10,.85) 0%,rgba(44,24,16,.5) 100%)}
.auth-left-content{position:absolute;inset:0;display:flex;flex-direction:column;justify-content:space-between;padding:2.5rem}
.auth-logo{display:flex;align-items:center;gap:.5rem}
.auth-logo-icon{color:#C4942A;font-size:1.3rem}
.auth-logo-text{font-family:var(--font-serif);font-size:1.4rem;font-weight:600;letter-spacing:.15em;color:#F5F0E8}
.auth-tagline{color:rgba(255,255,255,.9)}
.auth-tagline h2{font-family:var(--font-serif);font-size:2rem;font-weight:300;line-height:1.2;margin-bottom:.75rem}
.auth-tagline h2 em{font-style:italic;color:#D4A84B}
.auth-tagline p{font-size:.85rem;color:rgba(255,255,255,.65);line-height:1.7;max-width:320px}
.auth-features{display:flex;flex-direction:column;gap:.6rem}
.auth-feat{display:flex;align-items:center;gap:.6rem;font-size:.8rem;color:rgba(255,255,255,.75)}
.auth-feat-dot{width:6px;height:6px;border-radius:50%;background:#C4942A;flex-shrink:0}

/* RIGHT FORM PANEL */
.auth-right{display:flex;align-items:center;justify-content:center;padding:2rem;background:var(--off-white)}
.auth-box{width:100%;max-width:420px}
.auth-tabs{display:flex;border:1.5px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:2rem}
.auth-tab{flex:1;text-align:center;padding:.7rem;font-size:.78rem;font-weight:500;letter-spacing:.08em;text-transform:uppercase;color:var(--text-light);transition:all var(--transition);cursor:pointer}
.auth-tab.active{background:var(--brown);color:var(--white)}
.auth-tab:not(.active):hover{background:var(--cream);color:var(--brown)}
.auth-box h2{font-family:var(--font-serif);font-size:2rem;font-weight:400;color:var(--brown);margin-bottom:.4rem}
.auth-sub{font-size:.85rem;color:var(--text-light);margin-bottom:1.75rem;line-height:1.6}
.alert{padding:.8rem 1rem;border-radius:var(--radius);font-size:.84rem;margin-bottom:1.25rem}
.alert-error{background:#FEE2E2;color:#991B1B;border:1px solid #FCA5A5}
.alert-success{background:#D1FAE5;color:#065F46;border:1px solid #6EE7B7}
.form-group{margin-bottom:1.1rem}
.form-group label{display:flex;justify-content:space-between;align-items:center;font-size:.72rem;font-weight:500;text-transform:uppercase;letter-spacing:.07em;color:var(--text-mid);margin-bottom:.4rem}
.form-group label a{color:var(--gold);font-weight:400;text-transform:none;letter-spacing:0;font-size:.75rem}
.input-wrap{position:relative}
.form-group input{width:100%;padding:.8rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius);font-family:var(--font-sans);font-size:.9rem;color:var(--text);background:var(--white);outline:none;transition:border-color var(--transition),box-shadow var(--transition)}
.form-group input:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(196,148,42,.1)}
.form-group input.has-toggle{padding-right:2.5rem}
.pwd-eye{position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-light);font-size:.9rem;padding:0;line-height:1;transition:color var(--transition)}
.pwd-eye:hover{color:var(--gold)}
.remember-row{display:flex;align-items:center;gap:.5rem;margin-bottom:1.25rem;font-size:.83rem;color:var(--text-mid);cursor:pointer}
.remember-row input{accent-color:var(--gold);width:14px;height:14px}
.btn-auth{width:100%;padding:.9rem;background:var(--gold);color:var(--white);border:none;border-radius:var(--radius);font-family:var(--font-sans);font-size:.85rem;font-weight:500;letter-spacing:.1em;text-transform:uppercase;cursor:pointer;transition:all var(--transition)}
.btn-auth:hover{background:var(--brown);transform:translateY(-1px)}
.btn-auth:active{transform:translateY(0)}
.divider{display:flex;align-items:center;gap:1rem;margin:1.4rem 0;color:var(--text-light);font-size:.75rem}
.divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--border)}
.social-btns{display:grid;grid-template-columns:1fr 1fr;gap:.6rem;margin-bottom:1.4rem}
.btn-social{padding:.7rem;border:1.5px solid var(--border);border-radius:var(--radius);background:var(--white);font-family:var(--font-sans);font-size:.8rem;font-weight:500;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.5rem;color:var(--text-mid);transition:all var(--transition)}
.btn-social:hover{border-color:var(--gold);color:var(--gold)}
.auth-footer{text-align:center;font-size:.82rem;color:var(--text-light);margin-top:1.25rem}
.auth-footer a{color:var(--gold);font-weight:500}

@media(max-width:800px){
  .auth-wrap{grid-template-columns:1fr}
  .auth-left{display:none}
  .auth-right{padding:2rem 1.25rem}
}
</style>
</head>
<body>
<div class="auth-topstrip">
    Premium Furniture Since 2010 &nbsp;·&nbsp; Free Delivery Above ₹50,000
    <a href="/furniture-website/index.php">← Back to Store</a>
</div>

<div class="auth-wrap">
    <!-- LEFT PANEL -->
    <div class="auth-left">
        <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=900&q=85" alt="Mane Furniture Interior" />
        <div class="auth-left-overlay"></div>
        <div class="auth-left-content">
            <div class="auth-logo">
                <span class="auth-logo-icon">◈</span>
                <span class="auth-logo-text">MANE FURNITURE</span>
            </div>
            <div class="auth-tagline">
                <h2>Where Every Room<br><em>Tells a Story</em></h2>
                <p>Sign in to access your orders, wishlist, and exclusive member benefits.</p>
            </div>
            <div class="auth-features">
                <div class="auth-feat"><div class="auth-feat-dot"></div>Track your orders in real-time</div>
                <div class="auth-feat"><div class="auth-feat-dot"></div>Save your favourite pieces</div>
                <div class="auth-feat"><div class="auth-feat-dot"></div>Exclusive member-only offers</div>
                <div class="auth-feat"><div class="auth-feat-dot"></div>Free design consultation</div>
            </div>
        </div>
    </div>

    <!-- RIGHT FORM PANEL -->
    <div class="auth-right">
        <div class="auth-box">
            <div class="auth-tabs">
                <a href="/furniture-website/login.php" class="auth-tab active">Sign In</a>
                <a href="/furniture-website/register.php" class="auth-tab">Create Account</a>
            </div>

            <h2>Welcome Back</h2>
            <p class="auth-sub">Sign in to your Mane Furniture account to continue.</p>

            <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if (!empty($_GET['registered'])): ?>
            <div class="alert alert-success">✓ Account created successfully! Please sign in.</div>
            <?php endif; ?>
            <?php if (!empty($_GET['logout'])): ?>
            <div class="alert alert-success">✓ You have been signed out.</div>
            <?php endif; ?>

            <form method="POST" action="/furniture-website/login.php">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required placeholder="you@example.com"
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />
                </div>
                <div class="form-group">
                    <label>
                        Password
                        <a href="/furniture-website/forgot-password.php">Forgot password?</a>
                    </label>
                    <div class="input-wrap">
                        <input type="password" name="password" required placeholder="••••••••"
                            id="pwdField" class="has-toggle" />
                        <button type="button" class="pwd-eye" onclick="togglePwd('pwdField','eyeIcon')">
                            <span id="eyeIcon">👁</span>
                        </button>
                    </div>
                </div>
                <label class="remember-row">
                    <input type="checkbox" name="remember" />
                    Remember me for 30 days
                </label>
                <button type="submit" class="btn-auth">Sign In to My Account</button>
            </form>

            <div class="divider">or continue with</div>
            <div class="social-btns">
                <button class="btn-social" onclick="alert('Google login coming soon!')">
                    <svg width="16" height="16" viewBox="0 0 24 24"><path fill="#4285F4" d="M23.745 12.27c0-.79-.07-1.54-.19-2.27h-11.3v4.51h6.47c-.29 1.48-1.14 2.73-2.4 3.58v3h3.86c2.26-2.09 3.56-5.17 3.56-8.82z"/><path fill="#34A853" d="M12.255 24c3.24 0 5.95-1.08 7.93-2.91l-3.86-3c-1.08.72-2.45 1.16-4.07 1.16-3.13 0-5.78-2.11-6.73-4.96h-3.98v3.09C3.515 21.3 7.565 24 12.255 24z"/><path fill="#FBBC05" d="M5.525 14.29c-.25-.72-.38-1.49-.38-2.29s.14-1.57.38-2.29V6.62h-3.98a11.86 11.86 0 0 0 0 10.76l3.98-3.09z"/><path fill="#EA4335" d="M12.255 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C18.205 1.19 15.495 0 12.255 0c-4.69 0-8.74 2.7-10.71 6.62l3.98 3.09c.95-2.85 3.6-4.96 6.73-4.96z"/></svg>
                    Google
                </button>
                <button class="btn-social" onclick="alert('Phone login coming soon!')">
                    📱 Phone OTP
                </button>
            </div>

            <p class="auth-footer">Don't have an account? <a href="/furniture-website/register.php">Create one free →</a></p>
        </div>
    </div>
</div>

<script>
function togglePwd(id, iconId) {
    var f = document.getElementById(id);
    var i = document.getElementById(iconId);
    f.type = f.type === 'password' ? 'text' : 'password';
    i.textContent = f.type === 'password' ? '👁' : '🙈';
}
</script>
</body>
</html>
