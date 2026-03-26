<?php
if (session_status() === PHP_SESSION_NONE) session_start();
define('SITE_NAME', 'MANE FURNITURE');
define('SITE_TAGLINE', 'Premium Furniture');
$page_title = 'Create Account';

if (!empty($_SESSION['user'])) {
    header('Location: /furniture-website/index.php'); exit;
}

$error = '';
$data  = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'first_name' => trim(htmlspecialchars($_POST['first_name'] ?? '')),
        'last_name'  => trim(htmlspecialchars($_POST['last_name']  ?? '')),
        'email'      => filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL),
        'phone'      => trim(htmlspecialchars($_POST['phone'] ?? '')),
    ];
    $password  = $_POST['password']  ?? '';
    $password2 = $_POST['password2'] ?? '';

    if (!$data['first_name'] || !$data['last_name'] || !$data['email'] || !$password) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters long.';
    } elseif ($password !== $password2) {
        $error = 'Passwords do not match. Please try again.';
    } else {
        $config_path = __DIR__ . '/config/db.php';
        if (file_exists($config_path)) {
            try {
                require_once $config_path;
                $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->execute([$data['email']]);
                if ($stmt->fetch()) {
                    $error = 'An account with this email already exists.';
                } else {
                    $hash = password_hash($password, PASSWORD_BCRYPT);
                    $stmt = $pdo->prepare("INSERT INTO users (first_name,last_name,email,phone,password,role,status,created_at) VALUES (?,?,?,?,?,'customer','active',NOW())");
                    $stmt->execute([$data['first_name'],$data['last_name'],$data['email'],$data['phone'],$hash]);
                    header('Location: /furniture-website/login.php?registered=1'); exit;
                }
            } catch (Exception $e) {
                $error = 'Registration failed. Please try again later.';
            }
        } else {
            $error = 'Database not configured. Please set up config/db.php first.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Create Account — MANE FURNITURE</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
:root{--cream:#F5F0E8;--brown:#2C1810;--gold:#C4942A;--white:#fff;--off-white:#FAF8F4;--border:#DDD3C0;--text:#1A0F0A;--text-mid:#4A3728;--text-light:#8B7355;--radius:6px;--font-serif:'Cormorant Garamond',Georgia,serif;--font-sans:'Jost',sans-serif;--transition:.25s ease}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:var(--font-sans);font-weight:300;background:var(--off-white);min-height:100vh;display:flex;flex-direction:column}
a{color:inherit;text-decoration:none}
.auth-topstrip{background:var(--brown);color:var(--cream);text-align:center;padding:.5rem;font-size:.75rem;letter-spacing:.08em}
.auth-topstrip a{color:var(--gold);margin-left:.5rem}
.auth-wrap{flex:1;display:grid;grid-template-columns:1fr 1fr;min-height:calc(100vh - 40px)}
.auth-left{position:relative;overflow:hidden}
.auth-left img{width:100%;height:100%;object-fit:cover}
.auth-left-overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(26,15,10,.88) 0%,rgba(44,24,16,.55) 100%)}
.auth-left-content{position:absolute;inset:0;display:flex;flex-direction:column;justify-content:space-between;padding:2.5rem}
.auth-logo{display:flex;align-items:center;gap:.5rem}
.auth-logo-icon{color:#C4942A;font-size:1.3rem}
.auth-logo-text{font-family:var(--font-serif);font-size:1.4rem;font-weight:600;letter-spacing:.15em;color:#F5F0E8}
.auth-perks h3{font-family:var(--font-serif);font-size:1.4rem;font-weight:400;color:#D4A84B;margin-bottom:1rem}
.perk-item{display:flex;align-items:center;gap:.6rem;font-size:.82rem;color:rgba(255,255,255,.8);padding:.4rem 0;border-bottom:1px solid rgba(255,255,255,.08)}
.perk-dot{width:6px;height:6px;border-radius:50%;background:#C4942A;flex-shrink:0}
.auth-right{display:flex;align-items:flex-start;justify-content:center;padding:2rem;background:var(--off-white);overflow-y:auto}
.auth-box{width:100%;max-width:440px;padding:1rem 0}
.auth-tabs{display:flex;border:1.5px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:2rem}
.auth-tab{flex:1;text-align:center;padding:.7rem;font-size:.78rem;font-weight:500;letter-spacing:.08em;text-transform:uppercase;color:var(--text-light);transition:all var(--transition);cursor:pointer}
.auth-tab.active{background:var(--brown);color:var(--white)}
.auth-tab:not(.active):hover{background:var(--cream);color:var(--brown)}
.auth-box h2{font-family:var(--font-serif);font-size:1.9rem;font-weight:400;color:var(--brown);margin-bottom:.4rem}
.auth-sub{font-size:.85rem;color:var(--text-light);margin-bottom:1.5rem;line-height:1.6}
.alert{padding:.8rem 1rem;border-radius:var(--radius);font-size:.84rem;margin-bottom:1.25rem}
.alert-error{background:#FEE2E2;color:#991B1B;border:1px solid #FCA5A5}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:.85rem}
.form-group{margin-bottom:1rem}
.form-group label{display:block;font-size:.72rem;font-weight:500;text-transform:uppercase;letter-spacing:.07em;color:var(--text-mid);margin-bottom:.4rem}
.input-wrap{position:relative}
.form-group input,.form-group select{width:100%;padding:.78rem 1rem;border:1.5px solid var(--border);border-radius:var(--radius);font-family:var(--font-sans);font-size:.9rem;color:var(--text);background:var(--white);outline:none;transition:border-color var(--transition),box-shadow var(--transition)}
.form-group input:focus,.form-group select:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(196,148,42,.1)}
.form-group input.has-toggle{padding-right:2.5rem}
.pwd-eye{position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-light);font-size:.9rem;padding:0;transition:color var(--transition)}
.pwd-eye:hover{color:var(--gold)}
.pwd-strength{margin-top:.5rem}
.strength-track{height:4px;background:var(--cream);border-radius:20px;overflow:hidden;margin-bottom:.25rem}
.strength-fill{height:100%;border-radius:20px;transition:all .3s;width:0}
.strength-label{font-size:.72rem;color:var(--text-light)}
.check-row{display:flex;align-items:flex-start;gap:.5rem;margin-bottom:.75rem;font-size:.82rem;color:var(--text-mid);cursor:pointer;line-height:1.5}
.check-row input{accent-color:var(--gold);width:14px;height:14px;flex-shrink:0;margin-top:2px}
.check-row a{color:var(--gold)}
.btn-auth{width:100%;padding:.9rem;background:var(--gold);color:var(--white);border:none;border-radius:var(--radius);font-family:var(--font-sans);font-size:.85rem;font-weight:500;letter-spacing:.1em;text-transform:uppercase;cursor:pointer;transition:all var(--transition);margin-top:.5rem}
.btn-auth:hover{background:var(--brown);transform:translateY(-1px)}
.auth-footer{text-align:center;font-size:.82rem;color:var(--text-light);margin-top:1.25rem}
.auth-footer a{color:var(--gold);font-weight:500}
@media(max-width:800px){.auth-wrap{grid-template-columns:1fr}.auth-left{display:none}.auth-right{padding:1.5rem 1.25rem}.form-row{grid-template-columns:1fr}}
</style>
</head>
<body>
<div class="auth-topstrip">
    Premium Furniture Since 2010 &nbsp;·&nbsp; Free Delivery Above ₹50,000
    <a href="/furniture-website/index.php">← Back to Store</a>
</div>

<div class="auth-wrap">
    <div class="auth-left">
        <img src="https://images.unsplash.com/photo-1616594039964-ae9021a400a0?w=900&q=85" alt="Mane Furniture Bedroom" />
        <div class="auth-left-overlay"></div>
        <div class="auth-left-content">
            <div class="auth-logo">
                <span class="auth-logo-icon">◈</span>
                <span class="auth-logo-text">MANE FURNITURE</span>
            </div>
            <div class="auth-perks">
                <h3>Member Benefits</h3>
                <div class="perk-item"><div class="perk-dot"></div>Early access to new collections</div>
                <div class="perk-item"><div class="perk-dot"></div>Exclusive member-only discounts</div>
                <div class="perk-item"><div class="perk-dot"></div>Priority customer support</div>
                <div class="perk-item"><div class="perk-dot"></div>Save your wishlist and orders</div>
                <div class="perk-item"><div class="perk-dot"></div>Free interior design consultation</div>
                <div class="perk-item"><div class="perk-dot"></div>10-year warranty on all pieces</div>
            </div>
        </div>
    </div>

    <div class="auth-right">
        <div class="auth-box">
            <div class="auth-tabs">
                <a href="/furniture-website/login.php" class="auth-tab">Sign In</a>
                <a href="/furniture-website/register.php" class="auth-tab active">Create Account</a>
            </div>

            <h2>Join Mane Furniture</h2>
            <p class="auth-sub">Create your free account and unlock exclusive member benefits.</p>

            <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="/furniture-website/register.php">
                <div class="form-row">
                    <div class="form-group">
                        <label>First Name *</label>
                        <input type="text" name="first_name" required placeholder="Aditya"
                            value="<?= htmlspecialchars($data['first_name'] ?? '') ?>" />
                    </div>
                    <div class="form-group">
                        <label>Last Name *</label>
                        <input type="text" name="last_name" required placeholder="Mane"
                            value="<?= htmlspecialchars($data['last_name'] ?? '') ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label>Email Address *</label>
                    <input type="email" name="email" required placeholder="aditya@example.com"
                        value="<?= htmlspecialchars($data['email'] ?? '') ?>" />
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" placeholder="+91 98765 43210"
                        value="<?= htmlspecialchars($data['phone'] ?? '') ?>" />
                </div>
                <div class="form-group">
                    <label>Password *</label>
                    <div class="input-wrap">
                        <input type="password" name="password" required placeholder="Min. 8 characters"
                            id="pwd1" class="has-toggle" oninput="checkStrength(this.value)" />
                        <button type="button" class="pwd-eye" onclick="togglePwd('pwd1','eye1')">
                            <span id="eye1">👁</span>
                        </button>
                    </div>
                    <div class="pwd-strength" id="strengthWrap" style="display:none">
                        <div class="strength-track"><div class="strength-fill" id="strengthFill"></div></div>
                        <span class="strength-label" id="strengthLabel"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Confirm Password *</label>
                    <div class="input-wrap">
                        <input type="password" name="password2" required placeholder="Repeat your password"
                            id="pwd2" class="has-toggle" />
                        <button type="button" class="pwd-eye" onclick="togglePwd('pwd2','eye2')">
                            <span id="eye2">👁</span>
                        </button>
                    </div>
                </div>
                <label class="check-row">
                    <input type="checkbox" name="marketing" checked />
                    Send me exclusive offers and design inspiration
                </label>
                <label class="check-row">
                    <input type="checkbox" name="terms" required />
                    I agree to the <a href="/furniture-website/terms.php">Terms of Service</a> and <a href="/furniture-website/privacy.php">Privacy Policy</a> *
                </label>
                <button type="submit" class="btn-auth">Create My Account</button>
            </form>

            <p class="auth-footer">Already have an account? <a href="/furniture-website/login.php">Sign in →</a></p>
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
function checkStrength(v) {
    var wrap  = document.getElementById('strengthWrap');
    var fill  = document.getElementById('strengthFill');
    var label = document.getElementById('strengthLabel');
    wrap.style.display = v ? 'block' : 'none';
    var score = 0;
    if (v.length >= 8)           score++;
    if (/[A-Z]/.test(v))         score++;
    if (/[0-9]/.test(v))         score++;
    if (/[^A-Za-z0-9]/.test(v)) score++;
    var colors = ['#EF4444','#F59E0B','#3B82F6','#22C55E'];
    var labels = ['Weak — add uppercase & numbers','Fair — getting better','Good — add a symbol','Strong password ✓'];
    fill.style.width   = (score * 25) + '%';
    fill.style.background = colors[score - 1] || '#EF4444';
    label.textContent  = v.length < 8 ? 'Too short' : (labels[score - 1] || 'Too short');
}
</script>
</body>
</html>
