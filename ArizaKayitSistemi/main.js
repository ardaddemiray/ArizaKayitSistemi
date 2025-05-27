// ANASAYFA JS: Menü Aç/Kapa
const main = document.querySelector(".main-container"),
      sidebar = main.querySelector(".sidebar"),
      ok = main.querySelector(".ok");

ok.addEventListener("click", () => {
    sidebar.classList.toggle("close");
});

// BİLDİRİM SİSTEMİ
document.addEventListener("DOMContentLoaded", () => {
    const button = document.getElementById("notificationBtn");
    const dropdown = document.getElementById("notificationDropdown");
    const list = dropdown.querySelector("ul");
    const countSpan = button.querySelector(".notification-num");

    button.addEventListener("click", () => {
        const isOpen = dropdown.classList.toggle("show");
        if (isOpen) {
            fetch("bildirim-okundu.php", { method: "POST" })
                .then(() => {
                    countSpan.style.display = "none";
                });
        }
    });

    document.addEventListener("click", (e) => {
        if (!button.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.remove("show");
        }
    });

    function fetchBildirimler() {
        fetch("bildirimleri-getir.php")
            .then(res => res.json())
            .then(data => {
                if (!data.success) return;
                list.innerHTML = "";
                let unread = 0;

                if (data.bildirimler.length === 0) {
                    const li = document.createElement("li");
                    li.innerHTML = "<em>📭 Henüz bildiriminiz yok.</em>";
                    li.style.textAlign = "center";
                    li.style.padding = "10px";
                    list.appendChild(li);
                    countSpan.style.display = "none";
                    return;
                }

                data.bildirimler.forEach(b => {
                    const li = document.createElement("li");
                    li.innerHTML = `
                        ${b.baslik.includes("arıza") ? "🛠" : "✅"} 
                        <strong>${b.baslik}</strong><br>
                        <small>${b.mesaj}</small><br>
                        <span style="font-size:10px;color:gray;">${b.tarih}</span>
                    `;
                    if (b.goruldu == 0) unread++;
                    list.appendChild(li);
                });

                countSpan.textContent = unread;
                countSpan.style.display = unread > 0 ? "inline-block" : "none";
            })
            .catch(err => {
                console.error("Bildirim çekme hatası:", err);
            });
    }

    fetchBildirimler();
    setInterval(fetchBildirimler, 5000);
});

// AKS AI CHATBOX: Aç/Kapa
const chatboxToggle = document.querySelector('.chatbox-toggle');
const chatboxMessage = document.querySelector('.chatbox-message-wrapper');
const chatboxContent = document.querySelector(".chatbox-message-content");

let greetingShown = false; 

chatboxToggle.addEventListener('click', () => {
    chatboxMessage.classList.toggle('show');

    if (chatboxMessage.classList.contains('show') && !greetingShown) {
        const greeting = createMessage("received", "Merhaba ben AKS AI, size nasıl yardımcı olabilirim?");
        chatboxContent.appendChild(greeting);
        scrollChatToBottom();
        greetingShown = true;
    }
});

const aiShortcutBtn = document.getElementById('ai-shortcut');
if (aiShortcutBtn) {
    aiShortcutBtn.addEventListener('click', (e) => {
        e.preventDefault();

        // Chat kutusunu aç
        chatboxMessage.classList.add('show');

        // Hoş geldin mesajı gösterilmemişse göster
        if (!greetingShown) {
            const greeting = createMessage("received", "Merhaba, size nasıl yardımcı olabilirim?");
            chatboxContent.appendChild(greeting);
            scrollChatToBottom();
            greetingShown = true;
        }

        chatboxMessage.scrollIntoView({ behavior: "smooth", block: "center" });
    });
}


// CHATBOX MESAJ ALANI YÜKSEKLİĞİ
const textarea = document.querySelector('.chatbox-message-input');
const chatboxForm = document.querySelector('.chatbox-message-form');

textarea.addEventListener('input', () => {
    let line = textarea.value.split('\n').length;
    if (textarea.rows < 6 || line < 6) textarea.rows = line;
    chatboxForm.style.alignItems = textarea.rows > 1 ? 'flex-end' : 'center';
});

// Gemini AI Entegrasyonu
async function generateResponse(prompt) {
    const API_KEY = ""; /* GÜVENLİK AÇISINDAN APİ KEYİMİ KALDIRDIM */
    const API_URL = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent";

    const response = await fetch(`${API_URL}?key=${API_KEY}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            contents: [{
                parts: [{
                    text: `Sen bir teknik destek asistanısın. 
                    Kullanıcının sorunlarına sadece **Türkçe**, sade, kısa ve teknik odaklı şekilde cevap ver. 
                    Gereksiz bilgi verme, doğrudan çözüme odaklan. 
                    Eğer kullanıcı konu dışı bir şey sorarsa, kibarca sadece teknik destekle ilgili konulara yanıt verdiğini belirt. 
                    Şimdi kullanıcı soruyor: ${prompt}`
                }]
            }]
        })
    });

    if (!response.ok) {
        throw new Error("Yanıt alınamadı");
    }

    const data = await response.json();
    return data.candidates?.[0]?.content?.parts?.[0]?.text || "Yanıt boş geldi.";
}

chatboxForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    const message = textarea.value.trim();
    if (!message) return;

    const userMsg = createMessage("sent", message);
    chatboxContent.appendChild(userMsg);
    scrollChatToBottom();

    textarea.value = "";
    textarea.rows = 1;

    const loadingMsg = createMessage("received", "Yükleniyor...");
    chatboxContent.appendChild(loadingMsg);
    scrollChatToBottom();

    try {
        const cevap = await generateResponse(message);
        loadingMsg.querySelector(".chatbox-message-item-text").innerText = cevap;
        loadingMsg.querySelector(".chatbox-message-item-time").innerText = getCurrentTime();
    } catch (err) {
        loadingMsg.querySelector(".chatbox-message-item-text").innerText = "❌ Hata oluştu.";
        console.error(err);
    }
});

function createMessage(type, text) {
    const wrapper = document.createElement("div");
    wrapper.className = `chatbox-message-item ${type}`;

    const textEl = document.createElement("span");
    textEl.className = "chatbox-message-item-text";
    textEl.textContent = text;

    const timeEl = document.createElement("span");
    timeEl.className = "chatbox-message-item-time";
    timeEl.textContent = getCurrentTime();

    wrapper.appendChild(textEl);
    wrapper.appendChild(timeEl);
    return wrapper;
}

function getCurrentTime() {
    const now = new Date();
    return now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}

function scrollChatToBottom() {
    chatboxContent.scrollTop = chatboxContent.scrollHeight;
}
