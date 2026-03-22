<?php /* Your existing PHP header/includes if any */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marshall Network Services | Responsible AI Governance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style> body { font-family: system-ui, sans-serif; } </style>
</head>
<body class="bg-gray-50 text-gray-900">

<!-- HEADER + SOCIAL BAR -->
<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Marshall Network Services</h1>
        <nav class="flex gap-8 text-sm font-medium">
            <a href="/" class="hover:text-blue-600">Home</a>
            <a href="/marshall-principle/" class="hover:text-blue-600">Marshall Principle</a>
            <a href="/magrs/" class="hover:text-blue-600">MAGRS Framework</a>
            <a href="/magrs/ai-readiness/" class="hover:text-blue-600">AI Readiness Assessment</a>
        </nav>
        
        <!-- SOCIAL BAR (prominent & always visible) -->
        <div class="flex items-center gap-5 text-xl">
            <a href="https://x.com/RichMarshall" target="_blank" class="hover:text-blue-600"><i class="fab fa-x-twitter"></i></a>
            <a href="https://www.linkedin.com/in/YOUR-LINKEDIN-HANDLE" target="_blank" class="hover:text-blue-600"><i class="fab fa-linkedin"></i></a>
            <a href="https://youtube.com/@MarshallAIGov" target="_blank" class="hover:text-blue-600"><i class="fab fa-youtube"></i></a>
            <a href="https://YOUR-SUBSTACK.substack.com" target="_blank" class="hover:text-blue-600"><i class="fab fa-substack"></i></a>
        </div>
    </div>
</header>

<!-- HERO with graphic -->
<section class="relative h-screen flex items-center justify-center overflow-hidden bg-cover bg-center" 
         style="background-image: url('https://source.unsplash.com/random/1600x900/?ai-governance-human-network');">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative text-center text-white max-w-3xl px-6">
        <h2 class="text-5xl font-bold mb-6">Helping Organizations Remain Responsible as AI Enters Everyday Work</h2>
        <p class="text-xl mb-10">Artificial intelligence is now part of normal workflow. Human accountability must stay first.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/magrs/" class="bg-white text-gray-900 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100">Explore the MAGRS Framework</a>
            <a href="/magrs/ai-readiness/" class="border-2 border-white px-8 py-4 rounded-lg font-semibold hover:bg-white/10">Take the 7-Minute Assessment</a>
        </div>
    </div>
</section>

<!-- QUICK LINK CARDS (visual) -->
<section class="max-w-6xl mx-auto px-6 py-16 grid md:grid-cols-3 gap-8">
    <div class="bg-white p-8 rounded-xl shadow hover:shadow-lg transition">
        <img src="https://picsum.photos/id/1015/600/300" alt="MAGRS Framework" class="w-full h-48 object-cover rounded mb-6">
        <h3 class="text-2xl font-semibold mb-3">MAGRS Framework</h3>
        <p class="text-gray-600">Lightweight governance for human accountability in AI.</p>
        <a href="/magrs/" class="text-blue-600 mt-4 inline-block">Learn more →</a>
    </div>
    <div class="bg-white p-8 rounded-xl shadow hover:shadow-lg transition">
        <img src="https://picsum.photos/id/201/600/300" alt="Marshall Principle" class="w-full h-48 object-cover rounded mb-6">
        <h3 class="text-2xl font-semibold mb-3">The Marshall Principle</h3>
        <p class="text-gray-600">AI may assist — responsibility always remains with humans.</p>
        <a href="/marshall-principle/" class="text-blue-600 mt-4 inline-block">Read the principle →</a>
    </div>
    <div class="bg-white p-8 rounded-xl shadow hover:shadow-lg transition">
        <img src="https://picsum.photos/id/237/600/300" alt="About Richard" class="w-full h-48 object-cover rounded mb-6">
        <h3 class="text-2xl font-semibold mb-3">About Richard Marshall</h3>
        <p class="text-gray-600">Lexington, KY • 40+ years helping organizations build responsible systems.</p>
        <a href="#about" class="text-blue-600 mt-4 inline-block">Meet the founder →</a>
    </div>
</section>

<!-- ABOUT (unchanged text) -->
<section id="about" class="max-w-4xl mx-auto px-6 py-16 text-center">
    <p class="text-lg text-gray-700">Richard Marshall is a technology consultant based in Lexington, Kentucky with more than four decades of experience working with business networks, systems, and software infrastructure. His work now focuses on helping organizations remain conscious of responsibility as artificial intelligence becomes integrated into everyday professional work.</p>
</section>

<!-- ECOSYSTEM FOOTER (the hub you wanted) -->
<footer class="bg-gray-900 text-white py-12">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <p class="text-sm uppercase tracking-widest mb-4">Connect with the MAGRS Ecosystem</p>
        <div class="flex justify-center gap-8 text-3xl mb-8">
            <a href="https://x.com/RichMarshall" target="_blank"><i class="fab fa-x-twitter"></i></a>
            <a href="https://www.linkedin.com/in/YOUR-LINKEDIN-HANDLE" target="_blank"><i class="fab fa-linkedin"></i></a>
            <a href="https://youtube.com/@MarshallAIGov" target="_blank"><i class="fab fa-youtube"></i></a>
            <a href="https://YOUR-SUBSTACK.substack.com" target="_blank"><i class="fab fa-substack"></i></a>
        </div>
        <p class="text-gray-400 text-sm">© 2026 Marshall Network Services • Building responsible AI adoption, one organization at a time.</p>
    </div>
</footer>

<script>
    tailwind.config = { content: [], theme: { extend: {} } }
</script>
</body>
</html>