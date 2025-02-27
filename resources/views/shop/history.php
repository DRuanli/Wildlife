<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="min-h-screen bg-gradient-to-b from-purple-50 to-white pb-12">
    <!-- Purchase History Header -->
    <div class="relative overflow-hidden bg-purple-600 text-white">
        <div class="absolute opacity-20 right-0 top-0 w-full h-full">
            <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                <defs>
                    <pattern id="pattern" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M0 40L40 0" stroke="currentColor" stroke-width="1" fill="none" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#pattern)" />
            </svg>
        </div>
        <div class="container mx-auto px-4 py-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">Purchase History</h1>
                    <p class="text-purple-100 text-lg">Track your WildCoins spending and item acquisitions</p>
                </div>
                <div class="flex items-center bg-white bg-opacity-20 rounded-full px-4 py-2">
                    <i class="fas fa-coins text-yellow-300 mr-2"></i>
                    <span class="font-bold"><?= isset($user) ? number_format($user['coins_balance']) : 0 ?></span>
                    <span class="ml-1">WildCoins</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Transaction Filter -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-800">Filter Transactions</h2>
            </div>
            <div class="p-6">
                <form id="filter-form" class="flex flex-wrap gap-4">
                    <div class="w-full sm:w-auto">
                        <label for="period" class="block text-sm font-medium text-gray-700 mb-1">Time Period</label>
                        <select id="period" name="period" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="all">All Time</option>
                            <option value="30days">Last 30 Days</option>
                            <option value="90days">Last 90 Days</option>
                            <option value="year">This Year</option>
                        </select>
                    </div>
                    
                    <div class="w-full sm:w-auto">
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Transaction Type</label>
                        <select id="type" name="type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="all">All Types</option>
                            <option value="purchase">Purchases</option>
                            <option value="conservation">Conservation</option>
                            <option value="coins">Coin Purchases</option>
                        </select>
                    </div>
                    
                    <div class="w-full sm:w-auto sm:flex-grow">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" id="search" name="search" placeholder="Search by item name..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                    
                    <div class="w-full sm:w-auto self-end">
                        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Transaction Summary -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="px-6 py-4 bg-purple-100 border-b border-gray-200">
                <h2 class="text-lg font-bold text-purple-800">Transaction Summary</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Total Spent -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 mr-3">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total WildCoins Spent</p>
                                <p class="text-2xl font-bold text-gray-800">
                                    <?= number_format(isset($summary) ? $summary['total_spent'] : 12550) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Items Purchased -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-3">
                                <i class="fas fa-gift"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Items Purchased</p>
                                <p class="text-2xl font-bold text-gray-800">
                                    <?= number_format(isset($summary) ? $summary['items_purchased'] : 32) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Conservation Contributions -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 mr-3">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Conservation Contributions</p>
                                <p class="text-2xl font-bold text-gray-800">
                                    <?= number_format(isset($summary) ? $summary['conservation_contributions'] : 4850) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- WildCoins Purchased -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 mr-3">
                                <i class="fas fa-coins"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">WildCoins Purchased</p>
                                <p class="text-2xl font-bold text-gray-800">
                                    <?= number_format(isset($summary) ? $summary['coins_purchased'] : 20000) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Transaction History -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-purple-600 to-purple-700 text-white flex justify-between items-center">
                <h2 class="text-lg font-bold">Transaction History</h2>
                <div class="text-sm">
                    <?= count($transactions) ?> transactions
                </div>
            </div>
            
            <?php if (empty($transactions)): ?>
                <div class="p-8 text-center">
                    <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                        <i class="fas fa-receipt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-700 mb-2">No transactions found</h3>
                    <p class="text-gray-500 mb-4">Start shopping to see your purchase history here.</p>
                    <a href="<?= $baseUrl ?>/shop" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors">
                        <i class="fas fa-shopping-basket mr-2"></i> Visit Shop
                    </a>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Item
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($transactions as $transaction): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?= date('M j, Y', strtotime($transaction['created_at'])) ?>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            <?= date('g:i A', strtotime($transaction['created_at'])) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <?php if ($transaction['type'] == 'purchase' && isset($transaction['item_name'])): ?>
                                                <div class="w-10 h-10 bg-gray-100 rounded-md flex items-center justify-center mr-3">
                                                    <img src="<?= $baseUrl ?>/images/shop/<?= $transaction['reference_id'] ?>.png" alt="<?= htmlspecialchars($transaction['item_name']) ?>" class="max-h-8 max-w-8 object-contain">
                                                </div>
                                            <?php elseif ($transaction['type'] == 'purchase' && stripos($transaction['description'], 'coin') !== false): ?>
                                                <div class="w-10 h-10 bg-yellow-100 rounded-md flex items-center justify-center mr-3">
                                                    <i class="fas fa-coins text-yellow-500"></i>
                                                </div>
                                            <?php else: ?>
                                                <div class="w-10 h-10 bg-gray-100 rounded-md flex items-center justify-center mr-3">
                                                    <i class="fas fa-receipt text-gray-400"></i>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div>
                                                <?php if (isset($transaction['item_name'])): ?>
                                                    <div class="text-sm font-medium text-gray-900 max-w-xs truncate">
                                                        <?= htmlspecialchars($transaction['item_name']) ?>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="text-sm font-medium text-gray-900 max-w-xs truncate">
                                                        <?= htmlspecialchars($transaction['description']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php
                                        $typeClass = '';
                                        $typeLabel = '';
                                        
                                        if ($transaction['type'] == 'purchase' && $transaction['currency'] == 'coins') {
                                            if (isset($transaction['item_type']) && $transaction['item_type'] == 'conservation_package') {
                                                $typeClass = 'bg-green-100 text-green-800';
                                                $typeLabel = 'Conservation';
                                            } else {
                                                $typeClass = 'bg-purple-100 text-purple-800';
                                                $typeLabel = 'Item Purchase';
                                            }
                                        } elseif ($transaction['type'] == 'purchase' && $transaction['currency'] == 'real_money') {
                                            $typeClass = 'bg-yellow-100 text-yellow-800';
                                            $typeLabel = 'Coin Purchase';
                                        } else {
                                            $typeClass = 'bg-gray-100 text-gray-800';
                                            $typeLabel = ucfirst($transaction['type']);
                                        }
                                        ?>
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-medium rounded-full <?= $typeClass ?>">
                                            <?= $typeLabel ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <?php if ($transaction['currency'] == 'coins'): ?>
                                                <span class="text-sm font-medium text-gray-900 mr-1"><?= number_format($transaction['amount']) ?></span>
                                                <i class="fas fa-coins text-yellow-500 text-xs"></i>
                                            <?php else: ?>
                                                <span class="text-sm font-medium text-gray-900">$<?= number_format($transaction['amount'], 2) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <?php if (count($transactions) >= 20): ?>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <button class="px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-100 disabled:opacity-50" disabled>
                                Previous
                            </button>
                            <span class="text-sm text-gray-700">Page 1 of 3</span>
                            <button class="px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-100">
                                Next
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Transaction Detail Modal -->
<div id="transaction-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl max-w-md w-full overflow-hidden">
        <div class="bg-purple-600 px-6 py-4 text-white relative">
            <h3 class="text-xl font-bold">Transaction Details</h3>
            <button id="close-modal-btn" class="absolute top-4 right-4 text-white hover:text-purple-100">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <div class="flex items-center mb-6">
                <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center mr-4" id="modal-item-image">
                    <img src="<?= $baseUrl ?>/images/shop/golden-crown.png" alt="Golden Crown" class="max-h-12 max-w-12 object-contain">
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-800" id="modal-item-name">Golden Crown</h4>
                    <p class="text-sm text-gray-500" id="modal-item-type">Creature Accessory</p>
                </div>
            </div>
            
            <div class="space-y-4 mb-6">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Transaction ID:</span>
                    <span class="text-gray-900 font-medium" id="modal-transaction-id">TRX123456789</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Date & Time:</span>
                    <span class="text-gray-900" id="modal-transaction-date">Feb 25, 2023 · 3:45 PM</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Amount:</span>
                    <div class="flex items-center" id="modal-transaction-amount">
                        <span class="font-medium text-gray-900 mr-1">750</span>
                        <i class="fas fa-coins text-yellow-500"></i>
                    </div>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Status:</span>
                    <span class="text-green-600 font-medium" id="modal-transaction-status">Completed</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Description:</span>
                    <span class="text-gray-900 text-right" id="modal-transaction-description">Purchase of Golden Crown</span>
                </div>
            </div>
            
            <div class="text-center">
                <button id="close-details-btn" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter form functionality
    const filterForm = document.getElementById('filter-form');
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // In a real implementation, this would submit the form or make an AJAX request
            // For this demonstration, we'll just show an alert
            alert('Filters applied! In a real application, this would filter the transactions.');
        });
    }
    
    // Transaction detail modal functionality
    const transactionRows = document.querySelectorAll('tbody tr');
    const transactionModal = document.getElementById('transaction-modal');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const closeDetailsBtn = document.getElementById('close-details-btn');
    
    // Function to show transaction details
    function showTransactionDetails(transaction) {
        // Update modal content with transaction details
        document.getElementById('modal-item-name').textContent = transaction.itemName || transaction.description;
        document.getElementById('modal-item-type').textContent = transaction.itemType || transaction.type;
        document.getElementById('modal-transaction-id').textContent = 'TRX' + transaction.id;
        document.getElementById('modal-transaction-date').textContent = transaction.date;
        
        if (transaction.currency === 'coins') {
            document.getElementById('modal-transaction-amount').innerHTML = `
                <span class="font-medium text-gray-900 mr-1">${transaction.amount}</span>
                <i class="fas fa-coins text-yellow-500"></i>
            `;
        } else {
            document.getElementById('modal-transaction-amount').innerHTML = `
                <span class="font-medium text-gray-900">$${transaction.amount}</span>
            `;
        }
        
        document.getElementById('modal-transaction-status').textContent = transaction.status;
        document.getElementById('modal-transaction-description').textContent = transaction.description;
        
        // Update image
        const imageContainer = document.getElementById('modal-item-image');
        if (transaction.itemImage) {
            imageContainer.innerHTML = `<img src="${transaction.itemImage}" alt="${transaction.itemName}" class="max-h-12 max-w-12 object-contain">`;
        } else if (transaction.currency === 'coins') {
            imageContainer.innerHTML = `<i class="fas fa-receipt text-gray-400 text-2xl"></i>`;
        } else {
            imageContainer.innerHTML = `<i class="fas fa-coins text-yellow-500 text-2xl"></i>`;
        }
        
        // Show modal
        transactionModal.classList.remove('hidden');
    }
    
    // Function to close modal
    function closeTransactionModal() {
        transactionModal.classList.add('hidden');
    }
    
    // Add click event listeners to transaction rows
    transactionRows.forEach(row => {
        row.addEventListener('click', function() {
            // Extract transaction details from the row
            const dateEl = this.querySelector('td:nth-child(1)');
            const itemEl = this.querySelector('td:nth-child(2)');
            const typeEl = this.querySelector('td:nth-child(3)');
            const amountEl = this.querySelector('td:nth-child(4)');
            const statusEl = this.querySelector('td:nth-child(5)');
            
            const transaction = {
                id: Math.floor(Math.random() * 1000000000).toString(), // Random ID for demo
                date: dateEl.querySelector('.text-gray-900').textContent + ' · ' + dateEl.querySelector('.text-gray-500').textContent,
                itemName: itemEl.querySelector('.text-gray-900')?.textContent.trim(),
                itemType: typeEl.querySelector('span')?.textContent.trim(),
                amount: amountEl.querySelector('.text-gray-900')?.textContent.trim().replace(/[^\d.-]/g, ''),
                currency: amountEl.querySelector('.fa-coins') ? 'coins' : 'real_money',
                status: statusEl.querySelector('span')?.textContent.trim(),
                description: itemEl.querySelector('.text-gray-900')?.textContent.trim(),
                itemImage: itemEl.querySelector('img')?.src
            };
            
            showTransactionDetails(transaction);
        });
    });
    
    // Close modal when clicking the close button
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeTransactionModal);
    }
    
    // Close modal when clicking the close details button
    if (closeDetailsBtn) {
        closeDetailsBtn.addEventListener('click', closeTransactionModal);
    }
    
    // Close modal when clicking outside the content
    window.addEventListener('click', function(e) {
        if (e.target === transactionModal) {
            closeTransactionModal();
        }
    });
});
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>