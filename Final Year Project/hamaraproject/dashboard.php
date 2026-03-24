<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");

if (!isset($_SESSION['username'])) {
    header("Location: main.html");
    exit();
}

$today = date("d M Y");
$user = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>

<link rel="stylesheet" href="css/dashboard.css">

<!-- PDF + Canvas Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<!-- ✅ LOCAL QR CODE GENERATOR (no external API, no CORS) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<style>
    /* ===== CERTIFICATE LAYOUT ===== */
    .certificate {
        position: relative;
        width: 780px;
        height: 550px;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.25);
    }

    .cert-bg {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        object-fit: cover;
        z-index: 0;
    }

    .cert-content {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 30px;
        box-sizing: border-box;
        color: #2c2c2c;
    }

    .cert-content h1 {
        font-size: 36px;
        font-weight: 900;
        letter-spacing: 6px;
        color: #764ba2;
        margin: 0 0 6px;
        text-shadow: 1px 1px 3px rgba(255,255,255,0.9);
    }

    .cert-content .line {
        width: 200px;
        height: 3px;
        background: linear-gradient(to right, #764ba2, #667eea);
        margin: 6px auto 14px;
        border-radius: 2px;
    }

    .cert-content .of {
        font-size: 12px;
        letter-spacing: 2px;
        color: #555;
        margin-bottom: 4px;
    }

    .cert-content h2#pname {
        font-size: 32px;
        color: #222;
        font-weight: 800;
        margin: 4px 0;
        min-height: 40px;
        text-shadow: 1px 1px 2px rgba(255,255,255,0.9);
    }

    .cert-content p.sub {
        font-size: 13px;
        color: #444;
        margin: 6px 0 16px;
        min-height: 18px;
        font-style: italic;
    }

    /* ===== FOOTER ROW ===== */
    .cert-footer {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        width: 100%;
        margin-top: 10px;
        padding: 0 10px;
        box-sizing: border-box;
    }

    .sign-block, .date-block { text-align: center; }

    .sign-block .sign-name {
        font-size: 14px;
        font-weight: 700;
        color: #333;
        border-top: 2px solid #764ba2;
        padding-top: 4px;
        min-width: 130px;
        min-height: 20px;
    }

    .sign-block .sign-label,
    .date-block .date-label {
        font-size: 10px;
        color: #777;
        margin-top: 2px;
        letter-spacing: 1px;
    }

    .date-block .date-value {
        font-size: 14px;
        font-weight: 600;
        color: #333;
        border-top: 2px solid #764ba2;
        padding-top: 4px;
    }

    /* ===== QR CODE BLOCK ===== */
    .qr-block {
        display: flex;
        flex-direction: column;
        align-items: center;
        cursor: pointer;
    }

    /* ✅ QR renders inside this div via QRCode.js */
    #qr-container {
        width: 80px;
        height: 80px;
        background: #fff;
        border: 3px solid #764ba2;
        border-radius: 6px;
        padding: 3px;
        box-sizing: border-box;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        transition: transform 0.2s;
    }

    #qr-container:hover { transform: scale(1.08); }

    /* QRCode.js injects a canvas or img — make it fit */
    #qr-container canvas,
    #qr-container img {
        width: 100% !important;
        height: 100% !important;
        display: block;
    }

    .qr-block .qr-label {
        font-size: 9px;
        color: #666;
        margin-top: 3px;
        letter-spacing: 0.5px;
    }

    /* ===== SCAN POPUP ===== */
    #scanOverlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.6);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    #scanOverlay.active { display: flex; }

    #scanPopup {
        background: #fff;
        border-radius: 16px;
        padding: 30px 36px;
        max-width: 420px;
        width: 90%;
        text-align: center;
        box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        position: relative;
        animation: popIn 0.25s ease;
    }

    @keyframes popIn {
        from { transform: scale(0.85); opacity: 0; }
        to   { transform: scale(1);    opacity: 1; }
    }

    #scanPopup h2 { color: #764ba2; margin-bottom: 4px; font-size: 22px; }

    /* ✅ Popup QR div */
    #popup-qr-container {
        width: 160px;
        height: 160px;
        margin: 14px auto;
        border: 4px solid #764ba2;
        border-radius: 10px;
        padding: 5px;
        background: #fff;
        box-sizing: border-box;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    #popup-qr-container canvas,
    #popup-qr-container img {
        width: 100% !important;
        height: 100% !important;
        display: block;
    }

    .cert-info {
        text-align: left;
        background: #f7f0ff;
        border-radius: 10px;
        padding: 14px 18px;
        margin: 12px 0;
        font-size: 14px;
        line-height: 2;
        color: #333;
    }

    .cert-info strong { color: #764ba2; }

    #scanPopup .close-btn {
        position: absolute;
        top: 12px; right: 16px;
        background: none;
        border: none;
        font-size: 22px;
        cursor: pointer;
        color: #aaa;
    }

    #scanPopup .close-btn:hover { color: #764ba2; }

    .download-btn-popup {
        background: linear-gradient(135deg, #764ba2, #667eea);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 30px;
        font-size: 15px;
        cursor: pointer;
        margin-top: 6px;
        width: 100%;
        font-weight: 700;
        letter-spacing: 0.5px;
        transition: opacity 0.2s;
    }

    .download-btn-popup:hover { opacity: 0.88; }

    .scan-simulate-btn {
        display: block;
        margin: 12px auto 0;
        background: #fff;
        border: 2px solid #764ba2;
        color: #764ba2;
        padding: 9px 24px;
        border-radius: 25px;
        font-size: 14px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s;
    }

    .scan-simulate-btn:hover { background: #764ba2; color: #fff; }

    .preview-wrap { overflow-x: auto; }
</style>
</head>
<body>

<!-- HEADER -->
<header class="logo">
    <div style="display: flex; align-items: center; gap: 8px; margin-left: 5px;">
        <img src="Images/logo5.jpeg" class="logo" style="margin-left:-45px;">
        <h1 style="margin-left: -5px;"><b><u>CERTIFICATE GENERATOR PORTAL</u></b></h1>
    </div>
    <nav class="nav">
        <a href="abouts.php"><b>About</b></a>
        <a href="dashboard.php"><b>Template</b></a>
         <a href="help.php"><b>Help</b></a>

    </nav>
    <div class="right">
        <span style="color:#764ba2;font-size:20px;">
            <b>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></b>
        </span>
        <a href="logout.php" class="btn">Logout</a>
    </div>
</header>

<!-- HERO -->
<section class="hero">
    <div class="hero-left">
        <h1 style="color:white;">Free Online Certificate Generator</h1>
        <p style="color:white;">Create professional certificates online instantly.</p>
        <a href="#templates" class="cta-btn">Create Certificate</a>
    </div>
    <div class="hero-right">
        <img src="Images/logo6.jpeg">
    </div>
</section>

<!-- TEMPLATES -->
<section class="templates" id="templates">
    <h2>Select Certificate Template</h2>
    <div class="template-grid">
        <div class="template-card" onclick="openEditor('Images/certificate1.jpg')">
            <img src="Images/certificate1.jpg">
            <h4 style="color:#764ba2;">Template 1</h4>
        </div>
        <div class="template-card" onclick="openEditor('Images/certificate8.png')">
            <img src="Images/certificate8.png">
            <h4 style="color:#764ba2;">Template 2</h4>
        </div>
        <div class="template-card" onclick="openEditor('Images/cetificate9.png')">
            <img src="Images/cetificate9.png">
            <h4 style="color:#764ba2;">Template 3</h4>
        </div>
        <div class="template-card" onclick="openEditor('Images/certificate4.jpg')">
            <img src="Images/certificate4.jpg">
            <h4 style="color:#764ba2;">Template 4</h4>
        </div>
        <div class="template-card" onclick="openEditor('Images/certificate4.avif')">
            <img src="Images/certificate4.avif">
            <h4 style="color:#764ba2;">Template 5</h4>
        </div>
    </div>
</section>

<!-- EDITOR -->
<section class="editor" id="editor" style="display:none;">
    <div class="controls">
        <h2>Certificate Details</h2>

        <label>Recipient Name</label>
        <input type="text" id="name" oninput="updatePreview()" placeholder="e.g. Mayur Kolte">

        <label>Subtitle / Achievement</label>
        <input type="text" id="subtitle" oninput="updatePreview()" placeholder="e.g. Completion of Web Development">

        <label>Issued By (Signature)</label>
        <input type="text" id="signature" oninput="updatePreview()" placeholder="e.g. Dr. Ayesha patel">

        <label>Date</label>
        <input type="text" id="dateField" value="<?php echo $today; ?>" readonly>

        <button id="downloadBtn" onclick="createPDF()">⬇ Download PDF</button>
    </div>

    <div class="preview-wrap">
        <!-- CERTIFICATE -->
        <div class="certificate" id="certificate">
            <img id="bg" class="cert-bg" crossorigin="anonymous">

            <div class="cert-content">
                <h1>CERTIFICATE</h1>
                <div class="line"></div>
                <p class="of">THIS IS PROUDLY PRESENTED TO</p>
                <h2 id="pname">Your Name Here</h2>
                <p class="sub" id="psub">For outstanding achievement</p>

                <div class="cert-footer">
                    <!-- Signature -->
                    <div class="sign-block">
                        <div class="sign-name" id="psign"></div>
                        <div class="sign-label">AUTHORIZED SIGNATURE</div>
                    </div>

                    <!-- Date -->
                    <div class="date-block">
                        <div class="date-value"><?php echo $today; ?></div>
                        <div class="date-label">DATE OF ISSUE</div>
                    </div>

                    <!-- ✅ QR Code rendered locally by QRCode.js -->
                    <div class="qr-block" onclick="simulateScan()" title="Click to preview QR scan">
                        <div id="qr-container"></div>
                        <div class="qr-label">SCAN TO VERIFY</div>
                    </div>
                </div>
            </div>
        </div>

        <button class="scan-simulate-btn" onclick="simulateScan()">
            📷 Preview QR Scan Result
        </button>
    </div>
</section>

<!-- QR SCAN POPUP -->
<div id="scanOverlay" onclick="closeScanPopup(event)">
    <div id="scanPopup">
        <button class="close-btn" onclick="closeScan()">✕</button>
        <h2>🎓 Certificate Verified</h2>
        <p style="color:#888;font-size:13px;margin:0;">Scan QR code to verify certificate</p>

        <!-- ✅ Popup QR also rendered by QRCode.js -->
        <div id="popup-qr-container"></div>

        <div class="cert-info" id="popupInfo"></div>

        <button class="download-btn-popup" onclick="createPDF()">
            ⬇ Download Certificate as PDF
        </button>
    </div>
</div>

<script>
    // ── QR instance holders ────────────────────────────────────────────────
    let certQR  = null;   // QR on certificate
    let popupQR = null;   // QR in popup

    // ── Build certificate data string for QR ──────────────────────────────
    function buildQRData() {
        const name  = document.getElementById("name").value.trim()      || "N/A";
        const sub   = document.getElementById("subtitle").value.trim()  || "N/A";
        const sign  = document.getElementById("signature").value.trim() || "N/A";
        const date  = document.getElementById("dateField").value;
        const user  = "<?php echo addslashes($_SESSION['username']); ?>";

        return `CERTIFICATE DETAILS | Recipient: ${name} | Achievement: ${sub} | Issued By: ${sign} | Date: ${date} | Account: ${user}`;
    }

    // ── Generate / refresh QR in a given container ────────────────────────
    function generateQR(containerId, size) {
        const container = document.getElementById(containerId);
        container.innerHTML = ""; // Clear previous QR

        return new QRCode(container, {
            text:            buildQRData(),
            width:           size,
            height:          size,
            colorDark:       "#764ba2",   // Purple dots
            colorLight:      "#ffffff",
            correctLevel:    QRCode.CorrectLevel.M
        });
    }

    // ── Open editor with selected template ────────────────────────────────
    function openEditor(template) {
        const bgImg = document.getElementById("bg");

        bgImg.onload = function () {
            document.getElementById("editor").style.display = "flex";
            document.getElementById("editor").scrollIntoView({ behavior: "smooth" });

            // ✅ Generate initial QR as soon as editor opens
            certQR = generateQR("qr-container", 70);
        };
        bgImg.onerror = function () {
            alert("Image not found: " + template);
        };

        bgImg.src = template;
    }

    // ── Update live preview and regenerate QR ─────────────────────────────
    function updatePreview() {
        const name = document.getElementById("name").value;
        const sub  = document.getElementById("subtitle").value;
        const sign = document.getElementById("signature").value;

        document.getElementById("pname").innerText = name || "Your Name Here";
        document.getElementById("psub").innerText  = sub  || "For outstanding achievement";
        document.getElementById("psign").innerText = sign;

        // ✅ Regenerate QR with updated certificate data
        certQR = generateQR("qr-container", 70);
    }

    // ── Show QR scan popup ────────────────────────────────────────────────
    function simulateScan() {
        const name  = document.getElementById("name").value.trim()      || "N/A";
        const sub   = document.getElementById("subtitle").value.trim()  || "N/A";
        const sign  = document.getElementById("signature").value.trim() || "N/A";
        const date  = document.getElementById("dateField").value;
        const user  = "<?php echo addslashes($_SESSION['username']); ?>";

        // Generate larger QR in popup
        popupQR = generateQR("popup-qr-container", 145);

        // Fill info panel
        document.getElementById("popupInfo").innerHTML = `
            <strong>👤 Recipient:</strong> ${name}<br>
            <strong>🏆 Achievement:</strong> ${sub}<br>
            <strong>✍️ Issued By:</strong> ${sign}<br>
            <strong>📅 Date Issued:</strong> ${date}<br>
            <strong>🔑 Account:</strong> ${user}
        `;

        document.getElementById("scanOverlay").classList.add("active");
    }

    // ── Close popup ───────────────────────────────────────────────────────
    function closeScan() {
        document.getElementById("scanOverlay").classList.remove("active");
    }

    function closeScanPopup(e) {
        if (e.target === document.getElementById("scanOverlay")) closeScan();
    }

    // ── Generate & download PDF ───────────────────────────────────────────
    async function createPDF() {
        closeScan();

        const btn = document.getElementById("downloadBtn");
        btn.innerText = "⏳ Generating PDF...";
        btn.disabled = true;

        try {
            const certificate = document.getElementById("certificate");

            // Wait for background image to be ready
            const bgImg = document.getElementById("bg");
            await new Promise((resolve) => {
                if (bgImg.complete && bgImg.naturalWidth > 0) resolve();
                else { bgImg.onload = resolve; bgImg.onerror = resolve; }
            });

            // Small delay to ensure QR canvas is fully rendered
            await new Promise(r => setTimeout(r, 300));

            // ✅ html2canvas captures everything including local QR canvas
            const canvas = await html2canvas(certificate, {
                scale:           2,
                useCORS:         true,
                allowTaint:      true,   // ✅ Allow local canvas (QRCode.js) to render
                backgroundColor: "#ffffff",
                logging:         false
            });

            const imgData = canvas.toDataURL("image/jpeg", 1.0);

            const { jsPDF } = window.jspdf;
            const certW = certificate.offsetWidth;
            const certH = certificate.offsetHeight;

            const pdf = new jsPDF({
                orientation: certW > certH ? "landscape" : "portrait",
                unit:        "px",
                format:      [certW, certH]
            });

            pdf.addImage(imgData, "JPEG", 0, 0, certW, certH);

            const recipientName = document.getElementById("name").value.trim() || "certificate";
            pdf.save(`${recipientName}_certificate.pdf`);

        } catch (err) {
            alert("PDF generation failed: " + err.message);
            console.error(err);
        } finally {
            btn.innerText = "⬇ Download PDF";
            btn.disabled = false;
        }
    }
</script>

</body>
</html>