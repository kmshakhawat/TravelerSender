<x-guest-layout>
    <x-slot name="header" class="flex">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tracking') }}
            </h1>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="container">

            <div class="max-w-5xl mx-auto bg-white border border-gray-50 rounded shadow p-4">

                <div class="text-center">
                    <form name="tracking" method="GET" action="{{ route('tracking.search') }}">
                        <input class="form-input mb-4" type="text" name="trackingNumber" value="{{ request('trackingNumber') }}" placeholder="Enter Tracking Number">
                        <button class="btn-primary" type="submit">Search</button>
                    </form>
                </div>

                @if($tracking->isNotEmpty())
                    <div class="flex justify-between items-top my-10">
                        @php
                            $icons_old = [
                                '📦',
                                '🚚',
                                '🛒',
                                '🚚',
                                '🚚',
                                '🛵',
                                '🤲',
                            ];
                            $icons = [
                                '🔄', // Processing
        '📍', // Ready for Pickup
        '🚚', // Picked Up
        '🛣️', // In Transit
        '📦', // Arrived at Destination
        '📬', // Attempt to Deliver
        '📦', // Delivered
                            ];
                            $currentStatus = $currentStep;
                        @endphp

                        @foreach($steps as $index => $step)
                            <div class="flex flex-grow basis-full flex-col items-center relative">
                                <div class="w-16 h-16 relative z-20 rounded-full text-3xl flex justify-center items-center
                                    {{ $index === $currentStep ? 'bg-yellow-300 animate-bounce shadow-lg' : 'bg-gray-100' }}">
                                    {!! $icons[$index] !!}
                                </div>
                                @if(in_array($step, $completedStatuses))
                                    <div class="relative z-20 w-6 h-6 rounded-full bg-green-500 flex items-center justify-center text-white text-xs font-bold mt-2">
                                        ✓
                                    </div>
                                @else
                                    <div class="relative z-10 w-6 h-6 rounded-full bg-gray-300 mt-2"></div>
                                @endif

                                <div class="text-center text-sm mt-1 font-medium">
                                    {{ $step }}
                                    @if($index === $currentStep)
                                        <div class="text-xs text-yellow-700 font-semibold mt-1">You are here</div>
                                    @endif
                                </div>

                                @if ($index < count($steps) - 1)
                                    <div class="absolute top-[35px] left-16 z-10 w-full h-1 border-t-2 border-dotted
                {{ in_array($steps[$index + 1], $completedStatuses) ? 'border-green-500' : 'border-gray-300' }} z-0">
                                    </div>
                                @endif
                            </div>
                        @endforeach

                    </div>

                    @foreach ($tracking as $index => $track)
                        <div class="relative flex items-center space-x-4 py-6">
                            <!-- Step Icon -->
                            <div class="relative z-50">
                                <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white text-lg font-semibold">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>

                                </div>

                            </div>
                            @if ($index !== count($tracking) - 1)
                                <div style="width: 2px;top: 40px;" class="absolute z-10 left-0 transform -translate-x-1/2 h-full  bg-gray-100"></div>
                            @endif
                            <div class="flex-1">
                                <h3 class="font-semibold text-sm text-gray-800">{{ $track->status }}</h3>
                                <p class="text-xs text-gray-400">{{ getDateFormat($track->status_update_at, 'd M H:i') }}</p>
                                <p class="text-md text-gray-600">{{ $track->description }}</p>
                                @if($track->estimated_delivery)
                                    <p class="text-md text-gray-600">Estimated Delivery {{ getDateFormat($track->estimated_delivery, 'd M Y') }}</p>
                                @endif
                            </div>
                        </div>

                    @endforeach

{{--                    <div id="map" style="height: 500px;"></div>--}}

                    <!-- Leaflet -->
                    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
                    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

                    <!-- Leaflet Routing -->
                    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.min.js"></script>

                    <script>
                        const fromCity = @json($map_from);
                        const toCity = @json($map_to);

                        async function getLatLng(city) {
                            const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(city)}`);
                            const data = await res.json();
                            if (data.length > 0) {
                                return {
                                    lat: parseFloat(data[0].lat),
                                    lng: parseFloat(data[0].lon),
                                    name: data[0].display_name
                                };
                            } else {
                                throw new Error(`Location not found: ${city}`);
                            }
                        }

                        async function showMap() {
                            try {
                                const fromLocation = await getLatLng(fromCity);
                                const toLocation = await getLatLng(toCity);

                                // Initialize the map without setting the view yet
                                const map = L.map('map');

                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '&copy; OpenStreetMap contributors'
                                }).addTo(map);

                                // Custom icons with text labels
                                const fromIcon = L.divIcon({
                                    html: `<div class="leaflet-popup-content-wrapper"><div class="leaflet-popup-content" style="width: 215px;"><strong>From:</strong> ${fromCity}</div></div>`,
                                    className: 'location-marker from-marker',
                                    iconSize: null,
                                    iconAnchor: [0, 0]
                                });

                                const toIcon = L.divIcon({
                                    html: `<div class="leaflet-popup-content-wrapper"><div class="leaflet-popup-content" style="width: 215px;"><strong>To:</strong> ${toCity}</div></div>`,
                                    className: 'location-marker to-marker',
                                    iconSize: null,
                                    iconAnchor: [0, 0]
                                });

                                // Create marker groups to fit bounds
                                const markers = L.featureGroup();

                                // Add the custom markers with always visible labels
                                const fromMarker = L.marker([fromLocation.lat, fromLocation.lng], {icon: fromIcon})
                                    .addTo(map);
                                markers.addLayer(fromMarker);

                                const toMarker = L.marker([toLocation.lat, toLocation.lng], {icon: toIcon})
                                    .addTo(map);
                                markers.addLayer(toMarker);

                                // Add clickable markers with more detailed information
                                const fromInfoMarker = L.marker([fromLocation.lat, fromLocation.lng])
                                    .addTo(map)
                                    .bindPopup(`<strong>From:</strong> ${fromCity}<br><strong>Location:</strong> ${fromLocation.name}`);
                                markers.addLayer(fromInfoMarker);

                                const toInfoMarker = L.marker([toLocation.lat, toLocation.lng])
                                    .addTo(map)
                                    .bindPopup(`<strong>To:</strong> ${toCity}<br><strong>Location:</strong> ${toLocation.name}`);
                                markers.addLayer(toInfoMarker);

                                // Fit the map to show all markers with padding
                                map.fitBounds(markers.getBounds(), {
                                    padding: [50, 50], // Add padding around markers
                                    maxZoom: 12        // Limit max zoom level
                                });

                                // Add routing between the points
                                L.Routing.control({
                                    waypoints: [
                                        L.latLng(fromLocation.lat, fromLocation.lng),
                                        L.latLng(toLocation.lat, toLocation.lng)
                                    ],
                                    addWaypoints: false,
                                    draggableWaypoints: false,
                                    routeWhileDragging: false,
                                    showAlternatives: false,
                                    lineOptions: {
                                        styles: [{ color: 'blue', opacity: 0.7, weight: 6 }]
                                    },
                                    createMarker: function(i, waypoint, n) {
                                        // Don't create default routing markers
                                        return null;
                                    }
                                }).addTo(map);

                                // Hide the routing instructions container
                                const routingContainer = document.querySelector('.leaflet-routing-container');
                                if (routingContainer) routingContainer.style.display = 'none';

                                // Add some CSS to style the location labels
                                const style = document.createElement('style');
                                style.textContent = `
            .location-label {
                background-color: white;
                border: 1px solid #666;
                border-radius: 4px;
                padding: 2px 6px;
                font-size: 12px;
                white-space: nowrap;
                box-shadow: 0 1px 3px rgba(0,0,0,0.3);
                position: relative;
                top: -30px;
                left: 15px;
                z-index: 1000;
            }
            .from-marker .location-label {
                background-color: #e6f2ff;
            }
            .to-marker .location-label {
                background-color: #e6ffe6;
            }
        `;
                                document.head.appendChild(style);

                            } catch (error) {
                                alert(error.message);
                            }
                        }

                        // showMap();

                    </script>

                @else
                    <div class="text-center text-3xl font-medium my-10">No tracking information found for this number.</div>
                @endif

            </div>
        </div>
    </div>

</x-guest-layout>
