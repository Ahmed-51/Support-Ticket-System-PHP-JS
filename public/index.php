<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Submit Ticket</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
  <nav class="bg-white shadow">
    <div class="container mx-auto px-6 py-3">
      <span class="text-xl font-semibold text-gray-700">Support Center</span>
    </div>
  </nav>

  <div class="container mx-auto px-6 py-8">
    <div class="max-w-xl mx-auto bg-white p-8 shadow-lg rounded-lg">
      <h2 class="text-2xl font-bold mb-6 text-gray-800">Submit a Ticket</h2>
      <!-- <div id="response" class="mb-4 text-center text-red-500"></div> -->
      <form id="ticketForm" class="space-y-4">
        <div>
          <label for="name" class="block text-gray-700">Your Name</label>
          <input
type="text" id="name" name="name"
class="mt-1 p-1 block w-full border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
required>
        </div>
        <div>
          <label for="email" class="block text-gray-700">Your Email</label>
          <input
type="email" id="email" name="email"
class="mt-1 p-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
required>
        </div>
        <div>
          <label for="message" class="block text-gray-700">Issue Description</label>
          <textarea
id="message" name="message" rows="4"
class="mt-1 p-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
required></textarea>
        </div>
        <button
type="submit"
class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition">
          Submit Ticket
        </button>
      </form>
    </div>
  </div>

  <div id="response" class="mb-4 text-center"></div>

  <script src="../js/validation.js"></script>
  <script src="../js/ajax.js"></script>
</body>
</html>