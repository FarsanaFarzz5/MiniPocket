document.addEventListener("DOMContentLoaded", async () => {

    // 🧠 Clear ONLY when scanning page is opened from dashboard
    if (document.referrer.includes("/kid/dashboard")) {
        localStorage.removeItem("giftAmount");
        localStorage.removeItem("giftReason");
        localStorage.removeItem("goalAmount");
        localStorage.removeItem("goalReason");
        localStorage.removeItem("goalId");
    }
    
    const qr = new Html5Qrcode("reader");
    const config = { fps: 10, aspectRatio: 1.0, disableFlip: true };

    try {
        await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } });

        qr.start({ facingMode: "environment" }, config, decoded => {
            qr.stop().then(() => {
                window.location.href = `/kid/pay?data=${encodeURIComponent(decoded)}`;
            });
        });

    } catch (e) {
        console.warn("Camera unavailable:", e);
    }

    document.getElementById("qrFile").addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (!file) return;

        setTimeout(() => {
            window.location.href = "/kid/moneytransfer";
        }, 800);
    });
});
