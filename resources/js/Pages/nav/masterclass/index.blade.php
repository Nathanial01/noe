<!-- resources/views/livewire/calendar.blade.php -->

@push('title')
    Masterclass – Grip op de Nieuwe Huurwetten
@endpush

@push('description')
    Masterclass over de Wet Betaalbare Huur, Wet Goed Verhuurderschap &amp; Wet Vaste Huurcontracten. Ontdek hoe jij als verhuurder, ontwikkelaar of verhuurmakelaar voorbereid bent op de nieuwe huurwetgeving.
@endpush

<main class="min-h-screen flex flex-col">

    <header class="relative pt-6 pb-6 z-50">
        <x-website-header />
    </header>

    <!-- Dots in the background -->
    <x-website.dots class="-z-10" />

    <!-- Centered Content Container -->
    <div class="flex-grow flex items-center justify-center">
        <div class="w-full max-w-4xl p-8 sm:p-12 rounded-lg z-0">
            <!-- Page Header -->
            <header class="text-center mb-10 mt-20">
                <h1 class="text-4xl font-bold text-gray-900 leading-tight">
                    Masterclass: Grip op de Nieuwe Huurwetten<br>
                    <span class="block text-base font-normal text-gray-600 mt-2">
                        Wet Betaalbare Huur, Wet Goed Verhuurderschap &amp; Wet Vaste Huurcontracten
                    </span>
                </h1>
                <h2 class="text-2xl font-semibold text-gray-700 mt-4">
                    Schrijf je in en zorg dat je klaar bent voor de toekomst!
                </h2>
            </header>

            <!-- Main Article Content -->
            <article class="prose prose-indigo mx-auto text-gray-700">
                <section>
                    <p>
                        Ben jij verhuurder, vastgoedontwikkelaar of verhuurmakelaar en wil je <em>volledig op de hoogte zijn</em> van de nieuwste huurwetgeving? Schrijf je in voor onze Masterclass en zorg dat je klaar bent voor de toekomst!
                    </p>
                    <p>
                        De huurmarkt is in beweging. Met de invoering van de Wet Betaalbare Huur (per 1 juli 2024), de Wet Goed Verhuurderschap en de Wet Vaste Huurcontracten krijgen verhuurders en makelaars te maken met nieuwe regels en verplichtingen. Maar hoe vertaal je deze complexe wetgeving naar de praktijk? Hoe voorkom je risico’s en blijf je efficiënt én compliant?
                    </p>
                </section>

                <section>
                    <h3>Wat kun je verwachten?</h3>
                    <p>
                        In deze interactieve Masterclass nemen we je, aan de hand van praktijkvoorbeelden, mee in de laatste ontwikkelingen. We behandelen:
                    </p>
                    <ul>
                        <li>
                            <strong>Wet Betaalbare Huur</strong> – Hoe werkt het nieuwe huurpuntenstelsel? Wat betekent dit voor de huurprijs en het rendement van jouw vastgoed en hoe kun je door creativiteit je rendement optimaliseren?
                        </li>
                        <li>
                            <strong>Wet Goed Verhuurderschap</strong> – Wat mag wel en niet in het contact met huurders? Hoe voorkom je problemen bij handhaving en boetes?
                        </li>
                        <li>
                            <strong>Wet Vaste Huurcontracten</strong> – Wat verandert er in tijdelijke verhuur en hoe kun je flexibel blijven binnen de nieuwe regels?
                        </li>
                        <li>
                            <strong>Praktische strategieën</strong> – Hoe voldoe je efficiënt aan alle regels zonder in te leveren op rendement en service?
                        </li>
                    </ul>
                </section>

                <section>
                    <h3>Voor wie is deze Masterclass?</h3>
                    <p>
                        Deze Masterclass is speciaal ontwikkeld voor verhuurders, ontwikkelaars, beleggers, asset-managers en verhuurmakelaars die proactief willen inspelen op de nieuwe realiteit van de huurmarkt.
                    </p>
                </section>

                <!-- Video Section -->
                <section class="my-8">
                    <div class="aspect-w-16 aspect-h-9">
{{--                        <iframe--}}
{{--                            class="w-full h-full rounded-lg"--}}
{{--                            src="https://www.youtube.com/embed/aFYx5QlEEXk"--}}
{{--                            title="Masterclass Video"--}}
{{--                            frameborder="0"--}}
{{--                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"--}}
{{--                            allowfullscreen>--}}
{{--                        </iframe>--}}
                        <img
                            src="{{ Vite::asset('resources/images/masterclass.jpg') }}"
                            class="w-full h-full rounded-lg"
                            alt="Masterclass image"
                            title="Masterclass image" />
                    </div>
                </section>

                <section>
                    <h3>Waarom deelnemen?</h3>
                    <p>
                        - <strong>Actuele en praktijkgerichte kennis:</strong> We vertalen de wet naar concrete stappen voor jouw situatie.<br>
                        - <strong>Interactieve sessie met praktijkvoorbeelden:</strong> Geen droge theorie, maar direct toepasbare inzichten.<br>
                        - <strong>Voorkom risico’s en verhoog efficiëntie:</strong> Leer hoe je juridische valkuilen omzeilt en processen optimaliseert.<br>
                        - <strong>Vergroot je dienstverlening:</strong> Bied je klanten (huurders en investeerders) betere ondersteuning met up-to-date kennis.
                    </p>
                </section>

                <section>
                    <h3>Door heel Nederland!</h3>
                    <p>
                        De Masterclasses worden op verschillende locaties in het land gegeven. Bekijk onze agenda en meld je aan voor een sessie bij jou in de buurt!
                    </p>
                    <p>
                        Schrijf je nu in en blijf de markt een stap voor!
                    </p>
                </section>
            </article>

            <!-- Call-to-Action Button -->
            <div class="flex justify-center mt-12 mb-8">
                <a
                    href="agendaevent"
                    class="bg-yellow-400 hover:bg-yellow-500 transition-colors text-black px-8 py-3 font-semibold rounded-lg inline-flex items-center"
                >
                    Naar Agenda
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>

        </div>
    </div>

</main>
