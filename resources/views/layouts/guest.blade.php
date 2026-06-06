<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IPS Terminal | Secure Authentication Gate</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col items-center justify-center p-4 relative overflow-hidden">

    <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-900/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-emerald-900/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">
        
        <div class="text-center mb-8 space-y-2">
            <div class="inline-block bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 font-black px-3 py-1 rounded-md text-xs tracking-widest uppercase shadow-md">
                Secure Gateway
            </div>
            <h2 class="text-xl font-extrabold tracking-tight text-white">Islamia Public School Kuro</h2>
            <p class="text-xs text-slate-400 font-light">Administrative Framework & Management Terminal</p>
        </div>

        <div class="bg-slate-900/80 backdrop-blur-md border border-slate-800 p-8 rounded-2xl shadow-2xl space-y-6">
            {{ $slot }}
        </div>

        <p class="text-center text-[10px] text-slate-600 font-medium tracking-wide mt-6 uppercase">
            Authorized Personnel Only • Monitoring Active
        </p>
    </div>

</body>
</html>