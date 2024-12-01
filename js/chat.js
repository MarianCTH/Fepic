document.addEventListener("DOMContentLoaded", () => {
  const chatIcon = document.getElementById('chatIcon');
  const chatInterface = document.getElementById('chatInterface');
  const closeChatInterface = document.getElementById('closeChatInterface');

  chatIcon.addEventListener('click', () => {
    chatInterface.classList.toggle('open');
  });

  closeChatInterface.addEventListener('click', (e) => {
    e.preventDefault();
    chatInterface.classList.remove('open');
  });

  const msgerForm = get(".msger-inputarea");
  const msgerInput = get(".msger-input");
  const msgerChat = get(".msger-chat");

  let INTENT_RESPONSES = {};

  fetch("js/json/intent_responses.json")
    .then(response => response.json())
    .then(data => {
      INTENT_RESPONSES = data;
    })
    .catch(error => {
      console.error("Failed to load intent responses:", error);
    });

  const BOT_IMG = "images/profile/chatbot-fepic.jpg";
  const BOT_NAME = "BOT";

  const xhr = new XMLHttpRequest();
  xhr.open("GET", "js/php/get_user_loggedin.php", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        const isLoggedIn = response.isLoggedIn;

        const PERSON_NAME = isLoggedIn ? response.username : "Utilizator";
        const userPhoto = isLoggedIn ? "images/profile/" + response.profile_pic : "images/profile/default.png";

        msgerForm.addEventListener("submit", event => {
          event.preventDefault();

          const msgText = msgerInput.value;
          if (!msgText) return;

          appendMessage(PERSON_NAME, userPhoto, "right", msgText);
          msgerInput.value = "";

          const intent = detectIntent(msgText);
          generateBotResponse(intent);
        });
      } else {
        console.error("Failed to fetch login status");
      }
    }
  };
  xhr.send();

  function detectIntent(msgText) {
    const lowerMsg = msgText.toLowerCase();
    let closestMatch = "default";
    let highestSimilarity = 0;

    for (const intent in INTENT_RESPONSES) {
      const keywords = intent.split(" ");
      let totalSimilarity = 0;

      for (const keyword of keywords) {
        const similarity = calculateStringSimilarity(lowerMsg, keyword.toLowerCase());
        totalSimilarity += similarity;
      }

      if (totalSimilarity > highestSimilarity) {
        closestMatch = intent;
        highestSimilarity = totalSimilarity;
      }
    }

    return closestMatch;
  }


  function calculateStringSimilarity(str1, str2) {
    const distance = calculateEditDistance(str1, str2);
    const maxLength = Math.max(str1.length, str2.length);
    const similarity = 1 - distance / maxLength;
    return similarity;
  }

  function calculateEditDistance(str1, str2) {
    const matrix = [];

    for (let i = 0; i <= str2.length; i++) {
      matrix[i] = [i];
    }

    for (let j = 0; j <= str1.length; j++) {
      matrix[0][j] = j;
    }

    for (let i = 1; i <= str2.length; i++) {
      for (let j = 1; j <= str1.length; j++) {
        if (str2.charAt(i - 1) === str1.charAt(j - 1)) {
          matrix[i][j] = matrix[i - 1][j - 1];
        } else {
          matrix[i][j] = Math.min(
            matrix[i - 1][j - 1] + 1,
            matrix[i][j - 1] + 1,
            matrix[i - 1][j] + 1
          );
        }
      }
    }

    return matrix[str2.length][str1.length];
  }


  function appendMessage(name, img, side, text) {
    const msgHTML = `
    <div class="msg ${side}-msg">
      <div>
        <div class="msg-img" style="background-image: url(${img})"></div>
      </div>

      <div class="msg-bubble">
        <div class="msg-info">
          <div class="msg-info-name">${name}</div>
          <div class="msg-info-time">${formatDate(new Date())}</div>
        </div>

        <div class="msg-text">${text}</div>
      </div>
    </div>
  `;

    msgerChat.insertAdjacentHTML("beforeend", msgHTML);
    msgerChat.scrollTop += 500;
  }

  function generateBotResponse(intent) {
    let msgText = "Îmi pare rău, dar nu am înțeles. Te rog să reformulezi sau contactați o <a href='contact.php#contact-form' style='color:#6a49f2;'>persoană reală</a>";

    if (intent in INTENT_RESPONSES) {
      msgText = INTENT_RESPONSES[intent];
    }

    const delay = msgText.split(" ").length * 100;

    setTimeout(() => {
      appendMessage(BOT_NAME, BOT_IMG, "left", msgText);
    }, delay);
  }

  function get(selector, root = document) {
    return root.querySelector(selector);
  }

  function formatDate(date) {
    const h = "0" + date.getHours();
    const m = "0" + date.getMinutes();

    return `${h.slice(-2)}:${m.slice(-2)}`;
  }
});
