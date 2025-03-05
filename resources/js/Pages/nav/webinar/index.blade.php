@push('title')
Webinars - Huurprijscheck App
@endpush
@push('description')
Meer weten over de ins- & outs van de wetgeving? Dat is ons doel, en daarin nemen wij je graag mee.
@endpush
<main>
  <div x-data="{showFormModal: false}" class="relative bg-gray-800 overflow-hidden">

    <div x-cloak x-show="showFormModal" class="relative z-10" aria-labelledby="small-group" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto" >
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-xl" @click.outside="showFormModal = false">
              <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <h2>Op de hoogte blijven?</h2>
                <p>Laat een email achter en wordt op de hoogte gehouden!</p>

                <div class="flex flex-col pt-2">
                    <label for="email">Email</label>
                    <input type="text" class="rounded-md" name="email" wire:model.live="email">
                    @error('email')
                        <span class="text-xs text-red-500">{{$message}}</span>
                    @enderror
                </div>
                @if($send_webinar_request)
                <p class="text-green-500">Aanvraag verstuurd!</p>
                @endif
              </div>
              <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                @if(!$send_webinar_request)
                <button wire:click="sendWebinarRequest" type="button" class="inline-flex w-full justify-center rounded-md bg-green-500 px-3 py-2 text-sm font-semibold text-white shadow-sm sm:ml-3 sm:w-auto">Blijf op de hoogte</button>
                @endif
                <button @click="showFormModal = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
              </div>
            </div>
          </div>
        </div>
      </div>

    <div class="relative pt-6 pb-6">
      <x-website-header/>
    </div>
    <div class="relative py-16 bg-white overflow-hidden">
      <x-website.dots/>
      <div class="relative px-4 sm:px-6 lg:px-8">
        <div class="text-lg max-w-prose mx-auto">
          <h1>
            <span class="mt-2 block text-3xl text-center leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl mb-8">Webinars</span>
            <span class="block text-base text-center text-yellow-500 font-semibold tracking-wide uppercase">Meer weten over de ins- & outs van de wetgeving?<br>Dat is ons doel, en daarin nemen wij je graag mee.</span>
          </h1>
        </div>
        <div class="mt-6 prose prose-indigo prose-lg text-gray-500 mx-auto">
            {{-- <p>Meer weten over de ins- & outs van de wetgeving? Dat is ons doel, en daarin nemen wij je graag mee.</p> --}}
              <p class="font-semibold">Algemene webinars<p>
              <p>Deze organiseren wij periodiek voor onze klanten. Tijdens deze webinars besteden wij aandacht aan de volgende zaken:</p>
              <ul>
                  <li>Kaders van de wetgeving</li>
                  <li>Het WWS-systeem, hoe werkt het en waar moet ik op letten?</li>
                  <li>Hoe kan je woningen optimaliseren?</li>
                  <li>Hoe kan je efficiënt omgaan met de regels?</li>
              </ul>

            <p class="pt-4">Als je een account hebt, houden wij je automatisch op de hoogte van de data en tijden van de webinars.</p>
            <div class="mt-10 shadow-lg rounded-md bg-slate-100 p-4">     <img
                    src="{{ Vite::asset('resources/images/webnar.jpg') }}"
                    class="w-full h-96 rounded-lg"
                    alt="webnar image"
                    title="webnar image" />
                <h3 class="mt-0">Op de hoogte blijven</h3>
                <p>Heb je (nog) geen account, maar wil je ook op de hoogte blijven?</p>
                <a href="{{ route('website.register') }}"
                   class="inline-block px-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-semibold rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-300 transition">
                    Account aan maken
                </a>
            </div>
        </div>
      </div>
    </div>
  </div>
</main>
