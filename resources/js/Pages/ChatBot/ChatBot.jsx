import React, { useState, useEffect, useRef } from "react";
import axios from "axios";

export default function ChatBot() {
  const [isOpen, setIsOpen] = useState(false);
  const [messages, setMessages] = useState([
    { sender: "ChatGPT", text: "Hello! How can I help you today?" },
  ]);
  const [input, setInput] = useState("");
  const chatboxRef = useRef(null);

  // Example backend endpoint
  const API_URL = "https://cbotbackend-97abad6f3162.herokuapp.com/api/chat";

  // Toggle entire chat
  const toggleChat = () => setIsOpen((prev) => !prev);

  // Close if clicked outside
  useEffect(() => {
    const handleOutsideClick = (e) => {
      if (chatboxRef.current && !chatboxRef.current.contains(e.target)) {
        setIsOpen(false);
      }
    };
    if (isOpen) {
      document.addEventListener("mousedown", handleOutsideClick);
    } else {
      document.removeEventListener("mousedown", handleOutsideClick);
    }
    return () => document.removeEventListener("mousedown", handleOutsideClick);
  }, [isOpen]);

  // Send message
  const handleSend = async (e) => {
    e.preventDefault();
    if (!input.trim()) return;

    // Add user message
    const userMessage = { sender: "You", text: input };
    setMessages((prev) => [...prev, userMessage]);
    setInput("");

    try {
      const res = await axios.post(API_URL, {
        Name: "User Name",
        message: userMessage.text,
        subscription_tier: "free",
      });
      const data = res.data;
      const botMessage = {
        sender: "ChatGPT",
        text: data.reply || "No response received.",
      };
      setMessages((prev) => [...prev, botMessage]);
    } catch (error) {
      const errorMsg =
        error.response?.data?.error ||
        "Failed to connect to the server. Please try again later.";
      setMessages((prev) => [
        ...prev,
        { sender: "ChatGPT", text: errorMsg },
      ]);
    }
  };

  return (
    <div>
      {/* Toggle Button (only visible if chat is closed) */}
      {!isOpen && (
        <button
          onClick={toggleChat}
          className="fixed bottom-4 right-4 z-[9999] w-12 h-12 rounded-full bg-none text-white flex items-center justify-center shadow-lg"
        >
          {/* Simple ChatGPT-like icon */}
          <svg fill="none" height="896" viewBox="0 0 1024 896" width="1024"
                        >
                        <g fill="#fff">
                        <path
                        d="M687.394 637.505c5.994 26.978-10.621 50.503-37.413 54.417-21.064 3.077-41.46.977-61.559-5.583-3.798-1.239-7.879-1.826-11.447-3.519-7.94-3.767-14.83-1.63-22.167 2.038-45.474 22.728-91.949 43.197-139.707 60.669-26.501 9.695-53.473 17.826-81.767 20.013-25.45 1.967-50.498-1.15-75.277-7.279-32.391-8.012-70.26-46.359-67.242-91.233 1.621-24.106 10.29-45.687 22.203-66.612 16.313-28.654 40.18-49.905 64.752-70.737 3.558-3.016 7.009-6.18 10.748-8.954 3.11-2.307 3.066-4.113.328-6.703-11.863-11.221-23.63-22.545-35.394-33.871-19.931-19.19-38.205-33.728-57.665-59.623-13.395-17.825-15.088-18.904-30.281-48.404-9.615-18.67-15.78-31.001-12.713-52.251.963-6.675 1.502-10.573 4.213-16.749 3.157-7.192 5.646-11.264 11.5-16.5 10.317-9.227 23.286-11.066 33.733-10.871 28.021.521 55.322 5.246 81.257 16.409 4.894 2.107 9.789 4.211 14.677 6.334 1.749.759 3.247 1.14 5.027-.367 10.496-8.891 23.787-6.533 28.4 6.237 2.708 7.495 7.325 10.823 13.701 14.123 19.975 10.339 39.607 21.325 58.129 34.165 1.231.853 2.501 1.694 3.567 2.731 1.481 1.442 3.855 2.806 2.311 5.353-1.501 2.477-3.805 1.443-5.786.528-2.416-1.117-4.781-2.357-7.111-3.647-17.638-9.765-35.393-19.292-53.991-27.154-5.863-2.478-11.311-3.445-17.696-.488-9.331 4.322-18.819-.499-21.314-10.759-1.361-5.593-4.232-7.767-9.331-9.341-23.617-7.288-47.356-13.774-72.294-14.262a90 90 0 0 0-15.431 1.034c-22.828 3.502-28.086 21.736-25.655 37.087 2.746 17.345 11.19 32.291 19.998 47.064 23.5 39.411 54.882 71.91 89.24 101.817 13.451 11.708 27.029 23.257 41.074 34.248 1.801 1.411 3.67 2.735 5.501 4.095 2.792-2.761 5.23-5.228 7.73-7.633 11.336-10.905 26.757-7.497 35.33.563 14.639 13.766 22.352 30.6 19.001 51.143-.767 4.701.517 7.267 4.397 9.862 38.198 25.544 78.846 46.621 120.209 66.418 8.565 4.099 17.178 8.101 25.662 12.36 2.537 1.273 4.439 1.095 6.915-.221 38.008-20.203 69.717-48.298 99.223-79.124 7.829-8.179 15.571-16.495 22.694-25.282 16.775-20.692 28.425-42.764 30.833-73.966 1-12.956-7-34.853-34.84-48.937-11.063-5.597-34.66-14.019-34.66-14.019s-9.994-2.139-14-3.5c6.5-.564 16 1.5 16 1.5s28.045 6.708 44.322 13.54c6.445 2.705 20.178 12.46 20.178 12.46s21.021 21.178 21.758 38.956c1.381 33.295-9.067 62.895-28.382 89.711a243 243 0 0 1-24.868 29.307c-2.463 2.479-2.551 4.349-.959 7.354 6.016 11.357 10.82 23.237 14.339 36.053M371.305 598.71c-19.602 9.444-43.734-3.746-46.829-27.642-1.027-7.931-.107-15.596.626-23.355.179-1.889.659-3.583-1.158-4.945-5.323-3.991-10.595-8.05-15.932-12.021-3.046-2.266-5.726-1.599-8.486.874-5.456 4.886-11.273 9.373-16.658 14.333-15.234 14.031-29.387 28.968-39.675 47.213-9.745 17.281-12.553 36.335-14.853 55.553-2.112 17.652 4.552 31.844 17.275 43.688 10.729 9.987 22.887 17.774 36.333 23.452 20.607 8.702 42.039 12.111 64.408 9.749 16.804-1.774 32.937-6.454 49.235-10.47 42.39-10.444 84.214-22.658 124.433-39.877 4.627-1.982 9.252-3.971 14.162-6.079-2.338-2.416-4.732-3.156-7.034-4.064-41.83-16.504-81.53-36.992-118.262-63.066-5.964-4.233-12.157-8.143-18.25-12.192-3.645-2.422-6.781-1.934-9.66 1.441-2.504 2.934-5.638 5.169-9.675 7.408m249.254 76.673c8.089.517 15.936-.85 23.596-3.277 8.317-2.635 16.386-5.764 21.772-13.268 10.649-14.836 10.473-39.135-.432-54.141-.163-.223-.589-.254-1.585-.649-24.326 22.89-50.995 43.448-79.403 63.927 12.296 4.212 23.387 7.16 36.052 7.408"/>
                        <path
                        d="M505.569 509.485c-21.798 1.254-42.98.923-63.94-4.284-19.175-4.765-28.27-16.338-29.664-37.979-1.394-21.639 5.487-41.769 13.284-61.474 7.353-18.584 16.321-36.466 25.33-54.305 3.54-7.008 4.201-14.294 1.883-21.804-.717-2.326-1.851-4.619-4.766-4.2-4.397.632-7.467-.505-8.991-4.991-1.846-5.437-2.929-10.749 1.743-15.35 3.111-3.064 6.786-5.353 10.798-7.097 17.601-7.655 36.09-10.247 55.119-9.492 6.653.264 10.205 4.354 10.835 11.96.669 8.065-.327 15.929-2.853 23.644-4.041 12.336-7.458 24.877-12.219 36.976-.421 1.069-.923 2.172-.34 3.462 1.698 1.65 3.409.288 5.009-.264 14.166-4.885 28.826-6.853 43.707-6.895 8.132-.022 16.164-1.112 24.407-.428 22.406 1.86 37.408 19.52 40.436 42.065 5.016 37.345-13.146 63.236-41.367 83.878a154.9 154.9 0 0 1-42.929 22.102c-8.175 2.706-16.668 3.038-25.482 4.476m39.408-49.405c7.732-15.259 7.746-31.168 3.216-47.147-2.146-7.568-6.912-13.893-14.531-16.883-9.901-3.886-20.359-5.228-30.93-4.058-7.311.809-13.693 3.537-17.618 10.613-8.687 15.661-11.925 32.616-10.288 50.081 1.41 15.043 9.862 23.206 23.319 25.501 5.084.868 10.252 1.148 15.432.995 13.776-.407 24.994-5.08 31.4-19.102m48.228 98.311c-2.243 7.499-5.742 10.031-14.146 10.496-10.514.581-20.915-1.222-31.394-1.531-28.626-.845-57.228-1.041-85.747 2.129a1809 1809 0 0 0-29.719 3.555c-4.007.513-5.885-1.278-6.486-5.042-.866-5.422-1.975-10.807-2.729-16.243-1.427-10.283 3.856-17.191 14.202-17.311 21.633-.251 43.267-.187 64.909.499 24.279.77 48.592 1.019 72.858-.749 2.438-.177 4.805-1.272 7.213-1.911 6.655-1.764 9.633.103 11.099 6.867 1.36 6.281 1.276 12.552-.06 19.241M435.714 231.957c4.382.043 8.359.274 12.337.32 36.303.417 72.561-1.572 108.848-2.059 6.82-.092 13.634-.606 20.453-.834 2.384-.08 4.418-.522 6.446-2.077 3.252-2.493 7.279-1.314 8.32 2.639 2.601 9.872 1.518 19.535-3.594 28.418-2.187 3.8-6.313 4.46-10.53 4.441-17.819-.081-35.643-.321-53.457-.028-30.792.507-61.55 2.03-92.263 4.282-5.227.383-7.87-1.596-8.811-6.465-1.086-5.623-1.303-11.278.228-16.826 1.655-6.001 5.095-10.438 12.023-11.811"/>
                        </g>
                        </svg>
        </button>
      )}

      {/* Chat Container */}
      {isOpen && (
        <div
          ref={chatboxRef}
          className="fixed inset-0 md:inset-auto md:bottom-20 md:right-8 z-[9999] w-full md:w-96 h-full md:h-[60vh] bg-white dark:bg-gray-800 rounded-xl shadow-xl flex flex-col"
        >
          {/* Header with a close button */}
          <div className="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
            <h2 className="text-lg font-semibold text-gray-800 dark:text-gray-100">
             Cyrbot
            </h2>
            <button
              onClick={() => setIsOpen(false)}
              className="text-gray-600 dark:text-gray-300 hover:text-red-500"
            >
              {/* Close (X) Icon */}
              <svg
                xmlns="http://www.w3.org/2000/svg"
                className="w-5 h-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                strokeWidth="2"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>

          {/* Messages */}
          <div className="flex-1 p-4 overflow-y-auto space-y-4">
            {messages.map((msg, idx) => (
              <div
                key={idx}
                className={`flex ${
                  msg.sender === "You" ? "justify-end" : "justify-start"
                }`}
              >
                <div
                  className={`max-w-xs p-3 rounded-lg ${
                    msg.sender === "You"
                      ? "bg-blue-600 text-white rounded-br-none"
                      : "bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100 rounded-bl-none"
                  }`}
                >
                  {msg.text}
                </div>
              </div>
            ))}
          </div>

          {/* Bottom Toolbar: replicate the screenshot layout */}
          <form onSubmit={handleSend} className="border-t border-gray-200 dark:border-gray-700 p-3">
            {/* Single container to replicate the top text & bottom icons layout */}
            <div className="bg-gray-100 dark:bg-gray-700 rounded-md px-3 py-2 flex flex-col space-y-1">
              {/* The typed text on top (like in your screenshot) */}
              <input
                type="text"
                className="w-full bg-transparent border-none outline-none text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400"
                placeholder="Chat Cyrox...."
                value={input}
                onChange={(e) => setInput(e.target.value)}
                disabled={false}
              />

              {/* Icons row at the bottom */}
              <div className="flex items-center justify-between">
                <div className="flex items-center space-x-3">
                  {/* Plus Icon */}
                  <button
                    type="button"
                    className="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100"
                  >
                   <svg width="20" height="20" viewBox="0 0 0.6 0.6" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M.325.15a.025.025 0 1 0-.05 0v.125H.15a.025.025 0 1 0 0 .05h.125V.45a.025.025 0 1 0 .05 0V.325H.45a.025.025 0 1 0 0-.05H.325z" fill="#ffff"/></svg>
                  </button>

                  {/* Globe Icon
                  <button
                    type="button"
                    className="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="20"
                      height="20"
                      fill="none"
                      stroke="currentColor"
                      strokeWidth="2"
                      strokeLinecap="round"
                      strokeLinejoin="round"
                      className="w-5 h-5"
                      viewBox="0 0 24 24"
                    >
                      <circle cx="12" cy="12" r="10" />
                      <path d="M2 12h20M12 2v20" />
                    </svg>
                  </button> */}

             

                  {/* "o3-mini-high" text label */}
                  <span className="text-gray-700 dark:text-gray-100 text-sm">
                    o3-mini-high
                  </span>

                  {/* Microphone Icon */}
                  <button
                    type="button"
                    className="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100"
                  >
                 <svg width="20" height="20" viewBox="0 0 0.6 0.6" version="1.2" baseProfile="tiny"  style={{ fill: "#ffff" }}><path d="M.3.4A.1.1 0 0 1 .2.3V.15c0-.055.045-.1.1-.1s.1.045.1.1V.3a.1.1 0 0 1-.1.1m0-.3a.05.05 0 0 0-.05.05V.3c0 .028.022.05.05.05S.35.328.35.3V.15A.05.05 0 0 0 .3.1m.175.2V.25a.025.025 0 1 0-.05 0V.3a.125.125 0 0 1-.25 0V.25a.025.025 0 1 0-.05 0V.3c0 .088.065.161.15.173V.5H.2a.025.025 0 1 0 0 .05h.2A.025.025 0 1 0 .4.5H.325V.473A.175.175 0 0 0 .475.3"/></svg>
                  </button>
                </div>

                {/* Black Circle with White Up Arrow */}
                <button
                  type="submit"
                  className="bg-none text-white w-8 h-8 rounded-full flex items-center justify-center hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-gray-400"
                >
            <svg
      width="40"
      height="20"
      viewBox="0 0 1.2 1.2"
      data-name="Flat Color"
      className="icon flat-color"
      // style objects in React use camelCase
      style={{ fill: "#ffff" }}
    >
      <path
        d="m.986.464-.35-.35a.05.05 0 0 0-.071 0l-.35.35a.05.05 0 0 0 .071.071L.55.271v.779a.05.05 0 0 0 .1 0V.271l.265.265a.05.05 0 0 0 .071 0 .05.05 0 0 0 0-.071"
      />
    </svg>     </button>
              </div>
            </div>
          </form>
        </div>
      )}
    </div>
  );
}
