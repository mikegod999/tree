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
        let changeNodeTitleModal = $('#changeNodeTitleModal')
        let currentNodeId = null //node for edit

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

        function ajaxDeleteTree (nodeId, parentId) {
            $.ajax({
                url: '/tree/delete',
                method: 'POST',
                data: {id: nodeId},
                success: function (response) {
                    if (response.status === 'success') {
                        $('#node-' + nodeId).remove()
                        hideChildrenBtn(parentId)
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
                            $('#children-block-' + nodeId).append(response.data)
                        }
                    }
                }
            })
        }

        function ajaxEditTree (form) {
            let formArray = $(form).serializeArray()
            const dataObj = {}

            formArray.forEach(function (item) {
                dataObj[item.name] = item.value
            })

            dataObj.id = currentNodeId
            $.ajax({
                url: '/tree/edit',
                method: 'POST',
                data: dataObj,
                success: function (response) {
                    if (response.status === 'success') {
                        $('#node-title-' + currentNodeId).text($('#nodeTitle').val())
                        changeNodeTitleModal.modal('hide')
                    }
                    if (response.status === 'error') {
                        $('#error-title').text(response.message).show()
                    }
                }
            })
        }

        $('#editNodeForm').on('submit', function (e) {
            e.preventDefault()
            ajaxEditTree($(this))
        })

        $(document).on('click', '.addElement', function (e) {
            e.preventDefault()
            let nodeId = $(this).data('node-id')
            ajaxCreateTree(nodeId)
            showChildrenBtn(nodeId)
        })

        $(document).on('click', '.removeElement', function (e) {
            e.preventDefault()

            let nodeId = $(this).data('node-id')
            let parentId = $(this).data('parent-id')

            if (parentId === 0) {
                confirmDeleteModal.modal('show')
                rootNodeId = nodeId

                seconds = 20
                countdownTimer.text(seconds)

                countdownIntervalFunction(countdownTimer)
                return
            }

            ajaxDeleteTree(nodeId, parentId)
        })

        $(document).on('click', '.toggleChildren', function () {
            let nodeId = $(this).data('node-id')
            let childrenContainer = $('#children-block-' + nodeId)
            let icon = $(this).find('i')

            childrenContainer.slideToggle()

            if (icon.hasClass('bi-caret-down-fill')) {
                icon.removeClass('bi-caret-down-fill').addClass('bi-caret-right-fill')
            } else {
                icon.removeClass('bi-caret-right-fill').addClass('bi-caret-down-fill')
            }
        })

        function showChildrenBtn (nodeId) {
            let toggleBtn = $('#toggle-btn-' + nodeId)
            toggleBtn.removeAttr('hidden')
        }

        function hideChildrenBtn (nodeId) {
            let toggleBtn = $('#toggle-btn-' + nodeId)

            if ($('#children-block-' + nodeId).children().length === 0) {
                toggleBtn.attr('hidden', true)
            }
        }

        $(document).on('click', '.node-title', function () {
            currentNodeId = $(this).data('node-id')
            let currentTitle = $(this).text()

            $('#nodeTitle').val(currentTitle)
            changeNodeTitleModal.modal('show')
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