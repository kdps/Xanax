class Firebase {

	// Context

    private var FirebaseNotificationManager: NotificationManager? = null

    private var FirebaseContext: Context? = null
    private var FirebaseApplication: Application? = null
    
	@RequiresApi(Build.VERSION_CODES.LOLLIPOP)
    private var LockScreenVisibility = Notification.VISIBILITY_PRIVATE

    @RequiresApi(Build.VERSION_CODES.N)
    private var NotificationImportant = NotificationManager.IMPORTANCE_DEFAULT
    
	// Sound Context
	private var AlarmSound: Uri? = null
	
	// Vibration Context
	private var vibrationPattern: LongArray? = longArrayOf(1000)
	
	// Options
	
    private var useLight = false
    private var useVibration = false
    private var useSound = false
    private var useHeadUpNotification = false
    
	// Channel Data
	
    private var ChannelIdentify = "CHANNEL_ID"
    private var ChannelName = "CHANNEL_NAME"

    constructor(context: Context, application: Application) {
        FirebaseContext = context
        FirebaseApplication = application
    }

    fun setChannelName(name: String) {
      ChannelName = name

      return this
    }

    fun setChannelId(id: String) {
      ChannelIdentify = id

        return this
    }

    fun createNotificationChannel() {
      if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
	  	val notificationManager = mApplication!!.getSystemService(Context.NOTIFICATION_SERVICE) as NotificationManager
		
        val notificationChannel = NotificationChannel(channelId, channelName, NotificationImportant)
		notificationChannel.lockscreenVisibility = LockScreenVisibility
		
		if (useSound) {
			notificationChannel.setSound(AlarmSound, Notification.AUDIO_ATTRIBUTES_DEFAULT)
		} else {
			notificationChannel.setSound(null, null)
		}
		
		if (useVibration) {
			if (vibrationPattern != null) {
				notificationChannel.vibrationPattern = vibrationPattern
				notificationChannel.enableVibration(true)
			}
		}
		
		notificationChannel.enableLights(useLight)
		
		notificationManager.createNotificationChannel(notificationChannel)
      }
    }

    fun useHeadUpNotification(bool: Boolean): Firebase {
        useHeadUpNotification = bool

        return this
    }
    
    fun useSound(bool: Boolean): Firebase {
        useSound = bool

        return this
    }
    
    fun useVibration(bool: Boolean): Firebase {
        useVibration = bool

        return this
    }

}
