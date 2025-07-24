<x-filament::page>
    <div class="overflow-x-auto">
        <table class="table-auto w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="px-2 py-1 text-left">Level</th>
                    <th class="px-2 py-1 text-left">Message</th>
                    <th class="px-2 py-1 text-left">Datetime</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $index => $log)
                    @php
                        $badgeColor = match(strtoupper($log['level_name'] ?? '')) {
                            'ERROR'   => 'danger',
                            'WARNING' => 'warning',
                            'INFO'    => 'info',
                            default   => 'gray',
                        };
                    @endphp
                    <tr class="border-b" x-data="{ expanded: false }">
                        <td class="px-2 py-1">
                            <x-filament::badge color="{{ $badgeColor }}">
                                {{ $log['level_name'] }}
                            </x-filament::badge>
                        </td>
                        <td class="px-2 py-1 max-w-md">
                            <div 
                                class="truncate" 
                                :class="{ 'whitespace-normal': expanded }"
                            >
                                {{ $log['message'] }}
                            </div>
                            <button 
                                class="text-blue-500 text-xs mt-1 hover:underline"
                                @click="expanded = !expanded"
                                x-text="expanded ? 'Collapse' : 'Expand'">
                            </button>
                        </td>
                        <td class="px-2 py-1">
                            {{ $log['datetime'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-filament::page>
