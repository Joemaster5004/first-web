<?php
class Student{  //ชื่อคลาส
    //attibute
    public string $stdid;   
    public string $stdname;
    public int $age;

    //การกำหนด contruct
    public function __construct(String $stdid, String $stdname, int $age)
    {
        $this->stdid = $stdid;
        $this->stdname = $stdname;
        $this->age = $age;
    }

    //method
    public function getInfo() 
    {
        return "รหัสนักศึกษา: {$this->stdid} ชื่อ: {$this->stdname} อายุ: {$this->age}";
    }
}

$std = null;
$error = '';
$stdid = '';
$stdname = '';
$age = '';

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stdid = is_string($_POST['stdid'] ?? null) ? trim($_POST['stdid']) : '';
    $stdname = is_string($_POST['stdname'] ?? null) ? trim($_POST['stdname']) : '';
    $age = is_string($_POST['age'] ?? null) ? trim($_POST['age']) : '';
    $validAge = filter_var($age, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 120]]);

    if (!preg_match('/^[0-9]{1,20}$/', $stdid) || $stdname === '' || $validAge === false) {
        $error = 'กรุณากรอกข้อมูลให้ครบ โดยใช้รหัสนักศึกษาเป็นตัวเลขไม่เกิน 20 หลัก และอายุ 1–120 ปี';
    } else {
        $std = new Student($stdid, $stdname, $validAge);
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#153f37">
    <title>ข้อมูลนักศึกษา | FirstWeb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --forest: #153f37; --accent: #d3edb1; }
        body { font-family: 'Noto Sans Thai', sans-serif; color: #233b34; background: #f5f6f2; }
        .brand-mark { display: inline-grid; place-items: center; width: 38px; height: 38px; border-radius: 12px; background: var(--forest); color: var(--accent); font-weight: 700; }
        .eyebrow { font-size: .75rem; font-weight: 600; letter-spacing: .15em; }
        .hero-panel { background: var(--forest); color: white; border-radius: 28px; position: relative; overflow: hidden; }
        .hero-panel::after { content: ''; position: absolute; width: 290px; height: 290px; border: 1px solid #ffffff18; border-radius: 50%; bottom: -145px; right: -100px; box-shadow: 0 0 0 55px #ffffff05, 0 0 0 110px #ffffff04; pointer-events: none; }
        .hero-panel h1 { font-size: clamp(2rem, 4vw, 3rem); font-weight: 600; line-height: 1.5; }
        .hero-copy { color: #c1d4cc; line-height: 1.9; }
        .step-number { display: grid; place-items: center; width: 34px; height: 34px; border: 1px solid #ffffff35; border-radius: 50%; flex-shrink: 0; color: var(--accent); font-size: .8rem; }
        .form-panel { border: 1px solid #e5e9e2; border-radius: 28px; background: white; box-shadow: 0 16px 50px #193e3006; }
        .form-label { font-size: .9rem; font-weight: 600; }
        .form-control { border-color: #dfe5df; background: #fcfdfb; border-radius: 12px; padding: .85rem 1rem; }
        .form-control:focus { border-color: #4e8064; box-shadow: 0 0 0 .25rem #4e806418; }
        .form-control::placeholder { color: #9aa69e; font-size: .9rem; }
        .form-text { font-size: .75rem; color: #78867d; }
        .btn-save { background: var(--forest); color: white; padding: .9rem; border-radius: 12px; font-weight: 600; }
        .btn-save:hover, .btn-save:focus-visible { background: #235d4e; color: white; }
        .result-card { background: #edf5e5; border: 1px solid #d7e6c9; border-radius: 18px; }
        .result-card dt { font-size: .8rem; font-weight: 400; color: #62745d; }
        .result-card dd { overflow-wrap: anywhere; }
        .status-dot { width: 7px; height: 7px; border-radius: 50%; background: #63944b; display: inline-block; }
        @media (min-width: 992px) { main { padding-top: 3rem; padding-bottom: 3rem; } .hero-panel { min-height: 580px; } }
    </style>
</head>
<body>
    <header class="container py-4">
        <nav class="d-flex align-items-center justify-content-between" aria-label="เมนูหลัก">
            <a href="exam01.php" class="d-inline-flex align-items-center gap-2 text-decoration-none text-dark fw-semibold"><span class="brand-mark" aria-hidden="true">f.</span> FirstWeb<span class="text-secondary fw-normal d-none d-sm-inline"> / นักศึกษา</span></a>
            <span class="small text-secondary">ระบบข้อมูลนักศึกษา</span>
        </nav>
    </header>
    <main class="container pb-5">
        <div class="row g-4 align-items-stretch">
            <section class="col-lg-5">
                <div class="hero-panel p-4 p-md-5 h-100 d-flex flex-column justify-content-between gap-5">
                    <div>
                        <div class="eyebrow mb-4" style="color: var(--accent)">STUDENT INFORMATION</div>
                        <h1 class="mb-3">เริ่มต้นด้วย<br>ข้อมูลของคุณ</h1>
                        <p class="hero-copy mb-0">กรอกข้อมูลนักศึกษาในแบบฟอร์ม<br class="d-none d-lg-inline"> แล้วตรวจสอบรายละเอียดได้ทันที</p>
                    </div>
                    <div class="position-relative" style="z-index: 1">
                        <div class="d-flex gap-3 align-items-center mb-4"><span class="step-number">01</span><div><div class="mb-1">กรอกข้อมูลนักศึกษา</div><div class="small hero-copy">รหัสนักศึกษา ชื่อ และอายุ</div></div></div>
                        <div class="d-flex gap-3 align-items-center"><span class="step-number">02</span><div><div class="mb-1">ตรวจสอบรายละเอียด</div><div class="small hero-copy">แสดงข้อมูลหลังส่งแบบฟอร์ม</div></div></div>
                        <div class="mt-5 pt-4 border-top border-light border-opacity-10 small hero-copy">FIRSTWEB / แบบฝึกหัดที่ 01</div>
                    </div>
                </div>
            </section>
            <section class="col-lg-7" aria-labelledby="form-title">
                <div class="form-panel p-4 p-md-5 h-100">
                    <span class="eyebrow text-secondary">STUDENT PROFILE</span>
                    <h2 id="form-title" class="h3 fw-semibold mt-2 mb-2">เพิ่มข้อมูลนักศึกษา</h2>
                    <p class="text-secondary small mb-4">กรุณากรอกข้อมูลให้ครบทุกช่อง</p>

                    <?php if ($error !== ''): ?>
                        <div class="alert alert-danger rounded-3" role="alert"><?= escape($error) ?></div>
                    <?php endif; ?>

                    <form method="POST" action="exam01.php" class="d-grid gap-4">
                        <div>
                            <label for="stdid" class="form-label">รหัสนักศึกษา <span class="text-danger">*</span></label>
                            <input id="stdid" class="form-control" type="text" inputmode="numeric" pattern="[0-9]{1,20}" maxlength="20" name="stdid" placeholder="เช่น 69319010001" value="<?= escape($stdid) ?>" aria-describedby="stdid-help" required>
                            <div id="stdid-help" class="form-text mt-2">กรอกรหัสนักศึกษาเป็นตัวเลข ตามที่สถานศึกษากำหนด</div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-8">
                                <label for="stdname" class="form-label">ชื่อ–นามสกุล <span class="text-danger">*</span></label>
                                <input id="stdname" class="form-control" type="text" name="stdname" autocomplete="name" placeholder="เช่น นายสมชาย ใจดี" value="<?= escape($stdname) ?>" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="age" class="form-label">อายุ (ปี) <span class="text-danger">*</span></label>
                                <input id="age" class="form-control" type="number" name="age" min="1" max="120" placeholder="เช่น 20" value="<?= escape($age) ?>" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-save w-100 mt-2">แสดงข้อมูลนักศึกษา <span class="ms-2" aria-hidden="true">→</span></button>
                    </form>

                    <?php if ($std !== null): ?>
                        <section class="result-card p-4 mt-4" aria-labelledby="result-title" role="status">
                            <h3 id="result-title" class="h6 fw-semibold mb-3"><span class="status-dot me-2" aria-hidden="true"></span>ข้อมูลนักศึกษาของคุณ</h3>
                            <dl class="row g-3 mb-0">
                                <div class="col-sm-5"><dt>รหัสนักศึกษา</dt><dd class="mb-0 mt-1 fw-semibold"><?= escape($std->stdid) ?></dd></div>
                                <div class="col-sm-7"><dt>ชื่อ–นามสกุล</dt><dd class="mb-0 mt-1 fw-semibold"><?= escape($std->stdname) ?></dd></div>
                                <div class="col-12"><dt>อายุ</dt><dd class="mb-0 mt-1 fw-semibold"><?= $std->age ?> ปี</dd></div>
                            </dl>
                        </section>
                    <?php else: ?>
                        <p class="small text-secondary text-center mt-4 mb-0">ข้อมูลจะแสดงบนหน้านี้ และยังไม่ถูกบันทึกลงฐานข้อมูล</p>
                    <?php endif; ?>
                </div>
            </section>
        </div>
        <footer class="d-flex flex-wrap gap-2 justify-content-between mt-4 px-2 small text-secondary"><span>FirstWeb · พื้นที่เรียนรู้และพัฒนา</span><span>ข้อมูลนักศึกษา / 01</span></footer>
    </main>
</body>
</html>
