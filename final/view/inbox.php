<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inbox - JewelQuest</title>
    <link rel="stylesheet" href="../assets/css/inbox.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo-section">
            <div class="logo">
                <img src="../assets/images/logo.webp" alt="JewelQuest Logo">
            </div>
            <div class="nav-buttons">
                <a href="../index.php"" class="home-button">Home</a>
                <a href="create.php" class="create-button">Create</a>
            </div>
        </div>
    </nav>

    <!-- Inbox Container -->
    <div class="inbox-container">
        <div class="inbox-header">Chats</div>
        <div class="user-list" id="user-list">
            <!-- Example users added via JavaScript -->
        </div>
    </div>

    <!-- Chat Window -->
    <div class="chat-window" id="chat-window">
        <div class="chat-header">
            <span id="chat-header-title">Chat</span>
            <button class="close-chat" onclick="closeChat()">✕</button>
        </div>
        <div class="chat-messages" id="chat-messages"></div>
        <div class="chat-input">
            <label for="chat-input"><input type="text" id="chat-input" placeholder="Type a message..."></label>
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>

    <!-- JavaScript for Real-Time Chat -->
    <script>
        const chatWindow = document.getElementById("chat-window");
        const chatHeaderTitle = document.getElementById("chat-header-title");
        const chatMessages = document.getElementById("chat-messages");
        const chatInput = document.getElementById("chat-input");
        const userList = document.getElementById("user-list");

        const users = [
            { name: "John Doe", img: "https://i.pravatar.cc/50?img=1", status: "Online" },
            { name: "Jane Smith", img: "https://i.pravatar.cc/50?img=2", status: "Last seen 2 hours ago" },
            { name: "Alice Brown", img: "https://i.pravatar.cc/50?img=3", status: "Online" },
            { name: "Charlie Green", img: "https://i.pravatar.cc/50?img=4", status: "Last seen 5 minutes ago" },
            { name: "Emily White", img: "https://i.pravatar.cc/50?img=5", status: "Online" },
        ];

        // Load users into the user list
        users.forEach(user => {
            const userItem = document.createElement("div");
            userItem.classList.add("user-item");
            userItem.innerHTML = `
                <img src="${user.img}" alt="Profile Picture">
                <div class="user-info">
                    <div class="username">${user.name}</div>
                    <div class="status">${user.status}</div>
                </div>
                <button class="chat-button" onclick="openChat('${user.name}')">Chat</button>
            `;
            userList.appendChild(userItem);
        });

        function openChat(username) {
            chatWindow.classList.add("active");
            chatHeaderTitle.textContent = `Chat with ${username}`;
            chatMessages.innerHTML = ""; // Clear previous messages
        }

        function sendMessage() {
            const message = chatInput.value.trim();
            if (message) {
                const messageElement = document.createElement("div");
                messageElement.classList.add("message", "sent");
                messageElement.textContent = message;
                chatMessages.appendChild(messageElement);
                chatInput.value = "";
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        }

        function closeChat() {
            chatWindow.classList.remove("active");
        }
    </script>
</body>
</html>
