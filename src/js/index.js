(function ($) {
    const classTreeBuilder = function () {
        let rootBtn = $('#rootBtn')
        let rootNodeId = null
        let treeContainer = $('#treeContainer')
        let confirmDeleteModal = $('#confirmDeleteModal')
        let confirmDeleteBtn = $('#confirmDeleteBtn')
        let countdownTimer = $('#countdownTimer')
        let countdownInterval
        let seconds = 0

        function countdownIntervalFunction (timerElement) {
            clearCountdownInterval(countdownInterval) // очищення попереднього інтервалу

            countdownInterval = setInterval(() => {
                seconds--
                timerElement.text(seconds)

                if (seconds <= 0) {
                    clearCountdownInterval(countdownInterval)
                    confirmDeleteModal.modal('hide')
                }
            }, 1000)
        }

        function clearCountdownInterval (countdownInterval) {
            clearInterval(countdownInterval)
        }

        function ajaxDeleteTree (nodeId) {
            console.log('ajaxDeleteTree- ' + nodeId)
            $.ajax({
                url: '/tree/delete',
                method: 'POST',
                data: {id: nodeId},
                success: function (response) {
                    if (response.status === 'success') {
                        $('#node-' + nodeId).remove()
                    }
                }
            })
        }

        function ajaxCreateTree (nodeId) {
            $.ajax({
                url: '/tree/create',
                method: 'POST',
                data: {
                    id: nodeId
                },
                success: function (response) {
                    if (response.status === 'success') {
                        if (nodeId === 0) {
                            treeContainer.append(response.data)
                        } else {
                            $('#node-' + nodeId).append(response.data)
                        }

                    }

                }
            })
        }

        $(document).on('click', '.addElement', function (e) {
            e.preventDefault()
            let nodeId = $(this).data('node-id')
            ajaxCreateTree(nodeId)
        })

        $(document).on('click', '.removeElement', function (e) {
            e.preventDefault()

            let nodeId = $(this).data('node-id')
            let isRoot = $(this).data('root') === 1

            if (isRoot) {
                confirmDeleteModal.modal('show')
                rootNodeId = nodeId

                seconds = 20
                countdownTimer.text(seconds)

                countdownIntervalFunction(countdownTimer)
                return
            }

            ajaxDeleteTree(nodeId)
        })

        confirmDeleteBtn.on('click', function (e) {
            e.preventDefault()

            ajaxDeleteTree(rootNodeId)
            clearCountdownInterval(countdownInterval)
            confirmDeleteModal.modal('hide')
        })

        rootBtn.on('click', function (e) {
            e.preventDefault()

            if (treeContainer.children().length !== 0) {
                return
            }

            ajaxCreateTree(0)
        })
    }

    $(document).ready(function () {
        new classTreeBuilder()
    })
})($)