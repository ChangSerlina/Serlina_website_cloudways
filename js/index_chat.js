/**
 * Handles:
 *  - Toggling the floating chat window
 *  - Rendering markdown responses using the Marked library
 */

document.addEventListener('DOMContentLoaded', () => {
  const chatIcon = document.getElementById('chatIcon');
  const chatRegion = document.getElementById('chatRegion');
  const closeBtn = document.getElementById('closeChatBtn');
  const chatForm = document.getElementById('chatForm');
  const userInput = document.getElementById('userInput');
  const messagesContainer = document.getElementById('messagesContainer');

  let isChatOpen = false;
  const messages = [];

  function toggleChat() {
    isChatOpen = !isChatOpen;
    chatRegion.classList.toggle('closed', !isChatOpen);
  }

  async function sendMessage(event) {
    event.preventDefault();
    const text = userInput.value.trim();
    if (!text) return;

    // Add user message
    messages.push(`**您:** ${text}`);
    renderMessages();

    try {
      const response = await fetch('https://api.openai.com/v1/chat/completions', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer xxx` // TODO: 換成 chatgpt api key
        },
        body: JSON.stringify({
          model: 'o4-mini',
          messages: [{ role: 'user', content: text }]
        })
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();
      const aiMessage = data?.choices?.[0]?.message?.content || '(No response from AI)';
      messages.push(`**AI:** ${aiMessage}`);
    } catch (err) {
      console.error('Error sending message:', err);
      messages.push('**AI:** An error occurred while processing your request.');
    }

    renderMessages();
    userInput.value = '';
  }

  function renderMessages() {
    messagesContainer.innerHTML = '';
    messages.forEach(msg => {
      const div = document.createElement('div');
      div.className = 'message';
      div.innerHTML = marked.parse(msg); // Markdown rendering
      messagesContainer.appendChild(div);
    });
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
  }

  // Event listeners
  chatIcon.addEventListener('click', toggleChat);
  closeBtn.addEventListener('click', toggleChat);
  chatForm.addEventListener('submit', sendMessage);
});
