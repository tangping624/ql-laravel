!function ($) {
    "use strict"; // jshint ;_;

    var Uploader = function (element, options) {
        this.$element          = $(element)
        this.options           = options
        this.uploadQueue       = {}
        this.uploadQueueLength = 0

        this.$element.prop('sending', false)

        if (!this.options.url) {
            throw 'The option: url can not be empty.'
        }

        var uploader = this

        if (this.options.autoAdd) {
            this.$element.change(function () {
                uploader.add()
            })
        }
    }

    Uploader.prototype = {
        fileCount: 0
      , send: function () {
            var uploader = this
              , formData
              , uploadElementId

            for (uploadElementId in this.uploadQueue) {
                if (this.uploadQueue.hasOwnProperty(uploadElementId)) {
                    formData = new FormData
                    formData.append(this.$element.attr('name'), this.uploadQueue[uploadElementId])

                    // 没有队列在传输，又定义了 sending 方法，执行 sending 方法
                    if (!this.$element.prop('sending') && (typeof this.options.sending === 'function')) {
                        this.options.sending.call(this.$element[0])
                    }

                    this.$element.prop('sending', true);

                    $.ajax({
                        url: this.options.url
                      , type: this.options.type
                      , cache: false
                      , data: formData
                      , processData: false
                      , contentType: false
                      , dataType: this.options.dataType
                      , uploadElementId: uploadElementId
                      , xhr: function () {
                            var xhr = $.ajaxSettings.xhr()

                            if (typeof uploader.options.onProgress === 'function') {
                                // 带入当前的 jqXHR 对象
                                xhr.upload.jqXHR = this
                                xhr.upload.element = uploader.$element[0]

                                // 绑定 onprogress 事件方法
                                xhr.upload.onprogress = uploader.options.onProgress
                            }

                            return xhr
                        }
                    })
                    .done(function (response) {
                        uploader.uploadQueueLength--

                        if (typeof uploader.options.done === 'function') {
                            uploader.options.done.call(uploader.$element[0], response, this.uploadElementId)
                        }

                        if (uploader.uploadQueueLength == 0) {
                            uploader.$element.prop('sending', false)
                            if (typeof uploader.options.allDone === 'function') {
                                uploader.options.allDone.call(uploader.$element[0], response, this.uploadElementId)
                            }
                        }
                    })
                    .fail(function (response) {
                        if (typeof uploader.options.fail === 'function') {
                            uploader.options.fail.call(uploader.$element[0], response, this.uploadElementId)
                        }
                    })

                    delete this.uploadQueue[uploadElementId]
                }
            }
        }

        // 添加文件
      , add: function () {
            var uploadElementId, file, i

            for (i = 0; file = this.$element.prop('files')[i]; i++) {
                // 判断文件上传数量限制
                if (this.options.countLimit && this.fileCount >= this.options.countLimit && (typeof this.options.countLimitHandle === 'function')) {
                    this.options.countLimitHandle.call(this.$element[0])
                    break;
                }

                // 上传元素 id
                uploadElementId = 'uploader_' + Math.random().toString(36).substr(2)

                // 文件加载时执行的处理
                if (typeof this.options.onAdd === 'function') {
                    this.options.onAdd.call(this.$element[0], uploadElementId)
                }

                this.fileCount++

                // 需要处理图片
                if (file.type.match(/^(image)\/(jpeg|jpg|png)$/) // 文件类型是图片
                    && (this.options.imageClientProcess || typeof this.options.onImageLoad === 'function') // 本地缩放 或者 定义了图片加载的处理
                    ) {
                    var uploader = this
                      , reader = new FileReader()

                      reader.file = file
                      reader.uploadElementId = uploadElementId

                    reader.onload = function () {
                        var reader = this
                          , imageURI = this.result
                          , image = document.createElement('img')

                        image.src = imageURI

                        image.onload = function () {
                            // 定义了图片加载处理, 执行
                            if (typeof uploader.options.onImageLoad === 'function') {
                                uploader.options.onImageLoad.call(uploader.$element[0], imageURI, reader.uploadElementId)
                            }

                            if (uploader.options.imageClientProcess) {
                                var canvas = document.createElement('canvas') // 画布对象
                                  , ctx // 画布上下文
                                  , scalingRatio // 缩放比例
                                  , imageSize // 图片计算比例使用的尺寸
                                  , canvasSize // 画布计算比例使用的尺寸
                                  , startX, startY // 图片在画布的起始位置
                                  , targetWidth, targetHeight // 目标图片的的宽、高
                                  , imageRatio = this.width / this.height // 图片比例
                                  , canvasRatio = uploader.options.targetWidth / uploader.options.targetHeight // 画布比例
                                  , imageData // 图像数据
                                  , ia, i

                                if (uploader.options.imageRatio == 'origin') {
                                    imageSize     = imageSize > canvasSize ? Math.min(this.width, this.height) : Math.max(this.width, this.height)
                                    canvasSize    = Math.min(uploader.options.targetWidth, uploader.options.targetHeight)

                                    scalingRatio  = canvasSize / imageSize

                                    targetWidth   = scalingRatio * this.width
                                    targetHeight  = scalingRatio * this.height

                                    canvas.width  = targetWidth
                                    canvas.height = targetHeight

                                    startX = startY = 0
                                } else {
                                    imageSize = imageSize > canvasSize ? Math.max(this.width, this.height) : Math.min(this.width, this.height)
                                    canvasSize = Math.max(uploader.options.targetWidth, uploader.options.targetHeight)

                                    scalingRatio = canvasSize / imageSize

                                    targetWidth = scalingRatio * this.width
                                    targetHeight = scalingRatio * this.height

                                    canvas.width = uploader.options.targetWidth
                                    canvas.height = uploader.options.targetHeight

                                    // 根据水平对齐方式计算图像起点 x 坐标
                                    switch (uploader.options.imageAlignmentHorizontal) {
                                        case 'left':
                                            startX = 0
                                            break
                                        default:
                                        case 'center':
                                            startX = (uploader.options.targetWidth - targetWidth) / 2
                                            break
                                        case 'right':
                                            startX = uploader.options.targetWidth - targetWidth
                                            break
                                    }

                                    // 根据垂直对齐方式计算图像起点 y 坐标
                                    switch (uploader.options.imageAlignmentVertical) {
                                        case 'top':
                                            startY = 0
                                            break
                                        default:
                                        case 'center':
                                            startY = (uploader.options.targetHeight - targetHeight) / 2
                                            break
                                        case 'bottom':
                                            startY = uploader.options.targetHeight - targetHeight
                                            break
                                    }
                                }

                                ctx = canvas.getContext('2d')

                                ctx.drawImage(
                                    this,
                                    startX, // 图像起点 x 坐标
                                    startY, // 图像起点 y 坐标
                                    targetWidth, // 目标宽度
                                    targetHeight // 目标高度
                                );

                                // 获取画布数据，构建 blob 对象
                                imageURI = canvas.toDataURL(reader.file.type, uploader.options.quality / 100) // 获取新的 imageURI
                                imageData = window.atob(imageURI.split(',')[1])
                                ia = new Uint8Array(imageData.length)
                                for (i = 0; i < imageData.length; i++) {
                                    ia[i] = imageData.charCodeAt(i)
                                }
                                reader.file = new File([ia], reader.file.name, {type: reader.file.type}) // 构建新的 reader.file

                                if (typeof uploader.options.onImageProcess === 'function') {
                                    uploader.options.onImageProcess.call(uploader.$element[0], imageURI, reader.uploadElementId)
                                }
                            }

                            uploader.queue(reader.file, reader.uploadElementId)
                        }
                    }

                    reader.readAsDataURL(file)
                } else { // 非图片文件的处理
                    this.queue(file, uploadElementId)
                }
            }

            this.$element.val('')
        }

        // 将上传文件加入队列
      , queue: function (file, elementId) {
            this.uploadQueue[elementId] = file
            this.uploadQueueLength++

            if (this.options.autoUpload) {
                this.send()
            }
      }
    }

    var old = $.fn.uploader

    $.fn.uploader = function (option) {
        return this.each(function () {
            var $this = $(this)
              , data = $this.data('uploader')
              , options = $.extend({}, $.fn.uploader.defaults, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('uploader', (data = new Uploader(this, options)))
            if (typeof option == 'string') data[option]()
        })
    }

    $.fn.uploader.defaults = {
        // 属性
        url: null // 提交的 url
      , type: 'post' // 提交的方法
      , dataType: 'json' // 数据类型
      , imageClientProcess: false // 本地缩放图片
      , imageAlignmentHorizontal: 'center' //  图片水平对齐
      , imageAlignmentVertical: 'center' // 图片垂直对齐
      , targetWidth: 800 // 目标图片宽
      , targetHeight: 800 // 目标图片高
      , imageRatio: 'origin' // 图片比例: 'origin'.图片原始高宽比 'target'.目标图片比例
      , imageQuality: 92 // jpeg 图片品质
      , countLimit: 0 // 上传数量限制
      , autoUpload: true // 自动上传
      , autoAdd: true // 自动添加文件到上传队列
        // 方法
      , countLimitHandle: null // 到达上传数量的处理
      , onAdd: null // 图片添加时的处理
      , onImageLoad: null // 图片加载完毕的处理
      , onImageProcess: null // 图片客户端处理完毕
      , onProgress: null // 进度处理
      , done: null // 上传完毕的处理
      , fail: null // 上传失败的处理
      , sending: null // 正在传输时的处理
      , allDone: null // 队列完成的处理
    }

    $.fn.uploader.noConflict = function () {
        $.fn.uploader = old
        return this
    }
}(window.jQuery);
