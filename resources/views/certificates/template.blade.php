<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    font-family: Georgia, "Times New Roman", serif;
    background: #ffffff;
    color: #1a1a1a;
}
.page {
    width: 100%;
    min-height: 560px;
    padding: 48px 70px 40px;
    position: relative;
    border: 4px solid #C9A84C;
}
.inner-border {
    position: absolute;
    top: 10px; left: 10px; right: 10px; bottom: 10px;
    border: 1px solid rgba(201,168,76,.35);
}
.corner {
    position: absolute;
    width: 28px; height: 28px;
    border-color: #E0A020;
    border-style: solid;
}
.corner-tl { top: 18px; left: 18px; border-width: 2px 0 0 2px; }
.corner-tr { top: 18px; right: 18px; border-width: 2px 2px 0 0; }
.corner-bl { bottom: 18px; left: 18px; border-width: 0 0 2px 2px; }
.corner-br { bottom: 18px; right: 18px; border-width: 0 2px 2px 0; }

.site-name {
    text-align: center;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 11px;
    letter-spacing: 4px;
    text-transform: uppercase;
    color: #C9A84C;
    margin-bottom: 10px;
}
.divider {
    width: 60px;
    height: 2px;
    background: #E0A020;
    margin: 0 auto 22px;
}
.cert-title {
    text-align: center;
    font-size: 30px;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #C9A84C;
    font-weight: bold;
    margin-bottom: 6px;
}
.cert-subtitle {
    text-align: center;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 11px;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #888;
    margin-bottom: 32px;
}
.certify-line {
    text-align: center;
    font-size: 14px;
    color: #555;
    margin-bottom: 14px;
    font-style: italic;
}
.student-name {
    text-align: center;
    font-size: 36px;
    color: #1a1a1a;
    font-style: italic;
    margin-bottom: 6px;
}
.name-underline {
    width: 320px;
    height: 1.5px;
    background: #E0A020;
    margin: 0 auto 26px;
}
.course-line {
    text-align: center;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 13px;
    color: #555;
    margin-bottom: 10px;
}
.course-title {
    text-align: center;
    font-size: 22px;
    font-weight: bold;
    color: #C9A84C;
    margin-bottom: 10px;
}
.completion-date {
    text-align: center;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
    color: #777;
    margin-bottom: 28px;
}
.footer {
    margin-top: 20px;
    padding-top: 14px;
    border-top: 1px solid rgba(201,168,76,.25);
}
.footer-inner {
    width: 100%;
}
.footer-left { float: left; font-size: 11px; color: #555; font-family: Arial, sans-serif; }
.footer-right { float: right; font-size: 10px; color: #aaa; font-family: Arial, sans-serif; letter-spacing: 0.5px; }
</style>
</head>
<body>
<div class="page">
    <div class="inner-border"></div>
    <div class="corner corner-tl"></div>
    <div class="corner corner-tr"></div>
    <div class="corner corner-bl"></div>
    <div class="corner corner-br"></div>

    <div class="site-name">{{ $siteName }}</div>
    <div class="divider"></div>

    <div class="cert-title">Certificate of Completion</div>
    <div class="cert-subtitle">Islamic Online Learning Programme</div>

    <div class="certify-line">This is to certify that</div>

    <div class="student-name">{{ $userName }}</div>
    <div class="name-underline"></div>

    <div class="course-line">has successfully completed the course</div>
    <div class="course-title">{{ $courseTitle }}</div>
    <div class="completion-date">Completed on {{ $completionDate }}</div>

    <div class="footer">
        <div class="footer-inner">
            <span class="footer-left">{{ $siteName }}</span>
            <span class="footer-right">Certificate No: {{ $certNumber }}</span>
        </div>
        <div style="clear:both"></div>
    </div>
</div>
</body>
</html>
