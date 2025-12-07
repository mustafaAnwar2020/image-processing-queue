
<div class="bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-lg p-8">
    <h2 class="text-xl font-semibold mb-4 text-[#1b1b18] dark:text-[#EDEDEC]">Your Images</h2>
    

    @if($userImages->isEmpty())
        <div class="text-center py-12">
            <p class="text-[#706f6c] dark:text-[#A1A09A]">No images uploaded yet. Upload your first image above!</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="images-grid">
            @foreach($userImages as $image)
                <div class="relative group" data-image-id="{{ $image->id }}">
                    <div class="aspect-square overflow-hidden rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A]">
                        <img 
                            src="{{ $image->original_url }}" 
                            alt="Uploaded image"
                            class="w-full h-full object-cover"
                            onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\'%3E%3Crect fill=\'%23ddd\' width=\'100\' height=\'100\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%23999\'%3EImage%3C/text%3E%3C/svg%3E'"
                        >
                    </div>
                    <div class="mt-2">
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] truncate">
                            {{ basename($image->original_path) }}
                        </p>
                        <p class="text-xs text-[#706f6c] dark:text-[#A1A09A]">
                            {{ $image->created_at->format('M d, Y') }}
                        </p>
                        <p class="text-xs mt-1" id="status-{{ $image->id }}">
                            <span class="px-2 py-1 rounded text-xs status-badge
                                @if($image->status === 'pending') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                @elseif($image->status === 'processing') bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                                @elseif($image->status === 'failed') bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                                @elseif($image->status === 'done') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                @endif"
                                data-status="{{ $image->status }}">
                                {{ ucfirst($image->status) }}
                            </span>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <script>
        (function() {
            const statusEndpoint = '{{ route("dashboard.image-status") }}';
            const statusMap = {
                'pending': { 
                    class: 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200',
                    text: 'Pending'
                },
                'processing': { 
                    class: 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200',
                    text: 'Processing'
                },
                'failed': { 
                    class: 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200',
                    text: 'Failed'
                },
                'done': { 
                    class: 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
                    text: 'Done'
                }
            };

            function updateStatus(imageId, status) {
                const badge = document.querySelector(`#status-${imageId} .status-badge`);
                if (!badge) return;

                const currentStatus = badge.getAttribute('data-status');
                if (currentStatus === status) return;

                badge.setAttribute('data-status', status);
                badge.className = `px-2 py-1 rounded text-xs status-badge ${statusMap[status].class}`;
                badge.textContent = statusMap[status].text;
            }

            function checkStatus() {
                const imageElements = document.querySelectorAll('[data-image-id]');
                const imageIds = Array.from(imageElements).map(el => el.getAttribute('data-image-id'));
                
                if (imageIds.length === 0) return;

                const pendingIds = Array.from(imageElements)
                    .filter(el => {
                        const status = el.querySelector('.status-badge')?.getAttribute('data-status');
                        return status && status !== 'done' && status !== 'failed';
                    })
                    .map(el => el.getAttribute('data-image-id'));

                if (pendingIds.length === 0) return;

                fetch(statusEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                       document.querySelector('input[name="_token"]')?.value
                    },
                    body: JSON.stringify({ ids: pendingIds })
                })
                .then(response => response.json())
                .then(data => {
                    Object.keys(data).forEach(imageId => {
                        updateStatus(imageId, data[imageId].status);
                    });
                })
                .catch(error => console.error('Error checking status:', error));
            }

            
            setInterval(checkStatus, 2000);
            
            
            setTimeout(checkStatus, 1000);
        })();
        </script>
    @endif
</div>