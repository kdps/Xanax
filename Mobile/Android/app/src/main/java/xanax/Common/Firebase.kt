
import android.app.Application
import android.app.Notification
import android.app.NotificationChannel
import android.app.NotificationManager
import android.app.PendingIntent
import android.app.TaskStackBuilder
import android.content.Context
import android.content.Intent
import android.graphics.Bitmap
import android.graphics.drawable.BitmapDrawable
import android.media.Ringtone
import android.media.RingtoneManager
import android.net.Uri
import android.os.Build
import android.os.Handler
import android.os.Looper
import android.os.PowerManager
import android.os.Vibrator
import android.widget.RemoteViews
import android.widget.Toast
import androidx.core.app.NotificationCompat
import androidx.core.content.ContextCompat

class Firebase private constructor(application: Application, context: Context) {

    private var mContext: Context? = null
    private var mApplication: Application? = null
    private var pendingIntent: Intent? = null

    private var mNotificationManager: NotificationManager? = null

    private var AlarmSound: Uri? = null

    private var contentIntent: PendingIntent? = null

    private var vibrationPattern: LongArray? = longArrayOf(1000)

    private var REQUEST_ID = 0
    private var smallIcon = -1

    private var largeIcon: Bitmap? = null

    private var customBigContentView: RemoteViews? = null
    private var customHeadsUpContentView: RemoteViews? = null
    private var customContentView: RemoteViews? = null

    private var useSystemAPI = false
    private var useHeadUpNotification = true
    private var useStack = false
    private var useVibrate = true
    private var useAudio = true
    private var useBigStyle = false
    private var useBigPicture = false
    private val useWakeUp = false

    private var channelId = "CHANNELID"
    private var channelName = "CHANNELNAME"

    private var bigPicture: Bitmap? = null

    init {
        mContext = context
        mApplication = application
    }

    fun setVibrate(use: Boolean): Firebase {
        useVibrate = use

        return this
    }

    fun setAudio(use: Boolean): Firebase {
        useAudio = use

        return this
    }

    fun setChannelName(name: String): Firebase {
        channelName = name

        return this
    }

    fun setChannelId(id: String): Firebase {
        channelId = id

        return this
    }

    fun setHeadUpNotification(use: Boolean): Firebase {
        useHeadUpNotification = use

        return this
    }

    fun setPendingIntent(intent: Intent): Firebase {
        pendingIntent = intent

        return this
    }

    fun setDefaultRingtonAlarmSound(): Firebase {
        val alarmSound = RingtoneManager.getDefaultUri(RingtoneManager.TYPE_NOTIFICATION)
        this.setAlarmSound(alarmSound)

        return this
    }

    fun setRequestId(requestId: Int): Firebase {
        REQUEST_ID = requestId

        return this
    }

    fun useStack(stack: Boolean): Firebase {
        useStack = stack

        return this
    }

    fun setAlarmSound(alarm: Uri): Firebase {
        AlarmSound = alarm

        return this
    }

    fun setVibration(vibration: LongArray): Firebase {
        vibrationPattern = vibration

        return this
    }

    fun setLargeIcon(drawable: Int): Firebase {
        val bitmapDrawable = mContext!!.resources.getDrawable(drawable) as BitmapDrawable
        val bitmap = bitmapDrawable.bitmap

        this.setLargeIcon(bitmap)

        return this
    }

    fun setSmallIcon(drawable: Int): Firebase {
        smallIcon = drawable

        return this
    }

    fun setSystemAPI(use: Boolean): Firebase {
        useSystemAPI = use

        return this
    }

    fun setLargeIcon(icon: Bitmap): Firebase {
        largeIcon = icon

        return this
    }

    fun createChannel() {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            var importance = NotificationManager.IMPORTANCE_DEFAULT

            importance = NotificationManager.IMPORTANCE_HIGH

            val nc = NotificationChannel(channelId, channelName, importance)
            nc.lockscreenVisibility = Notification.VISIBILITY_PRIVATE

            if (importance != NotificationManager.IMPORTANCE_HIGH) {
                if (useAudio) {
                    if (!useSystemAPI) {
                        if (AlarmSound != null) {
                            nc.setSound(AlarmSound, Notification.AUDIO_ATTRIBUTES_DEFAULT)
                        } else {
                            nc.setSound(null, null)
                        }
                    } else {
                        playAlarmSound()
                    }
                }
            } else {
                if (AlarmSound != null) {
                    nc.setSound(AlarmSound, Notification.AUDIO_ATTRIBUTES_DEFAULT)
                } else {
                    nc.setSound(null, null)
                }
            }

            if (useVibrate) {
                if (!useSystemAPI) {
                    nc.vibrationPattern = vibrationPattern
                    if (vibrationPattern != null) {
                        nc.enableVibration(true)
                    }
                } else {
                    vibrate()
                }
            }

            nc.enableLights(true)

            val manager = mApplication!!.getSystemService(Context.NOTIFICATION_SERVICE) as NotificationManager
            manager?.createNotificationChannel(nc)
        }
    }

    private fun vibrate() {
        val vibrator = mApplication!!.getSystemService(Context.VIBRATOR_SERVICE) as Vibrator
        if (vibrator != null) {
            vibrator.vibrate (vibrationPattern, 0);
        }
    }

    fun setCustomContentView(contentView: RemoteViews) {
        customContentView = contentView
    }

    fun setCustomBigContentView(contentView: RemoteViews) {
        customBigContentView = contentView
    }

    fun setCustomHeadsUpContentView(contentView: RemoteViews) {
        customHeadsUpContentView = contentView
    }

    private fun playAlarmSound() {
        if (AlarmSound != null) {
            val r = RingtoneManager.getRingtone(mContext, AlarmSound)
            r.play()
        }
    }

    fun useBigPicture(use: Boolean, picture: Bitmap) {
        useBigPicture = use
        bigPicture = picture
    }

    fun useBigStyle(use: Boolean) {
        useBigStyle = use
    }

    fun showToast(title: String, message: String) {
        val handler = Handler(Looper.getMainLooper())
        handler.post { Toast.makeText(mContext, message, Toast.LENGTH_LONG).show() }
    }

    fun useWakeUp(use: Boolean) {
	useWakeUp = use
    }

    fun showNotification(title: String?, message: String?) {
        mNotificationManager = mApplication!!.getSystemService(Context.NOTIFICATION_SERVICE) as NotificationManager

        if (pendingIntent != null) {
            if (useStack) {
                TaskStackBuilder stackBuilder = TaskStackBuilder.create (mContext);
                stackBuilder.addNextIntent (pendingIntent);
                contentIntent = stackBuilder.getPendingIntent (0, PendingIntent.FLAG_UPDATE_CURRENT);
            } else {
                pendingIntent!!.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP)
                contentIntent = PendingIntent.getActivity(mContext!!.applicationContext, 0, pendingIntent, PendingIntent.FLAG_ONE_SHOT)
            }
        }

        var mBuilder = NotificationCompat.Builder(mContext!!.applicationContext)

        // Create Channel When Higher then Android Oreo
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            mBuilder = NotificationCompat.Builder(mContext!!, channelId)
            this.createChannel()
        }

        if (contentIntent != null) {
            mBuilder.setContentIntent(contentIntent)
        }

        // Set Small Icon
	if (smallIcon != null) {
		if (ContextCompat.getDrawable(mContext!!, smallIcon) != null) {
			mBuilder.setSmallIcon(smallIcon)
		}
	}

        // Set Large Icon
        if (largeIcon != null) {
            mBuilder.setLargeIcon(largeIcon)
            mBuilder.setStyle(NotificationCompat.BigTextStyle().bigText(message))
        }

        // Set Title Attributes
        if (title != null) {
            mBuilder.setContentTitle(title)
        }
        // Set Message Attributes
        if (message != null) {
            mBuilder.setContentText(message).setAutoCancel(true)
        }

        // Manual Vibrate Because It doesn't Automatic Fired In Higher then Android Oreo
        if (Build.VERSION.SDK_INT < Build.VERSION_CODES.O) {
            if (useVibrate) {
                if (!useSystemAPI) {
                    mBuilder.setVibrate(vibrationPattern)
                } else {
                    vibrate()
                }
            }
        }

        // Manual Audio Because It doesn't Automatic Fired In Higher then Android Oreo
        if (Build.VERSION.SDK_INT < Build.VERSION_CODES.O) {
            if (useAudio) {
                if (!useSystemAPI) {
                    if (AlarmSound != null) {
                        mBuilder.setSound(AlarmSound)
                    } else {
                        mBuilder.setSound(null)
                    }
                } else {
                    playAlarmSound()
                }
            }
        }

	// Set Custom View Of Big Style
        if (customContentView != null) {
            mBuilder.setCustomBigContentView(customContentView)
        }

    	// Set Custom View
        if (customContentView != null) {
            mBuilder.setCustomContentView(customContentView)
        }

	// Set Custom View Of Heads Up Style
        if (customHeadsUpContentView != null) {
            mBuilder.setCustomHeadsUpContentView(customHeadsUpContentView)
        }

    	// TODO
        if (useHeadUpNotification) {
            mBuilder.setPriority(NotificationCompat.PRIORITY_HIGH)
        }

        // Wake Up When In Receive Notification Message
        if (useWakeUp) {
            val pm = mContext!!.getSystemService(Context.POWER_SERVICE) as PowerManager
            var wakeLock: PowerManager.WakeLock? = null

            if (pm != null) {
                wakeLock = pm.newWakeLock(PowerManager.SCREEN_BRIGHT_WAKE_LOCK or PowerManager.ACQUIRE_CAUSES_WAKEUP or PowerManager.ON_AFTER_RELEASE, "")
            }

            if (wakeLock != null) {
                wakeLock.acquire()
                wakeLock.release()
            }
        }

        // Set Big Picture Notification Style
        if (useBigPicture) {
            val bigStyle = NotificationCompat.BigPictureStyle(mBuilder)
            bigStyle.setBigContentTitle(title)
            bigStyle.setSummaryText(message)
            bigStyle.bigPicture(bigPicture)

            mBuilder.setStyle(bigStyle)
        }

        // Set Big Text Notification Style
        if (useBigStyle) {
            val bigStyle = NotificationCompat.BigTextStyle(mBuilder)
            bigStyle.setBigContentTitle(title)
            bigStyle.bigText(message)

            mBuilder.setStyle(bigStyle)
        }

        mBuilder.setPriority(NotificationCompat.PRIORITY_HIGH)
        mBuilder.setWhen(System.currentTimeMillis())
        mBuilder.setAutoCancel(true)
        mBuilder.setDefaults(Notification.DEFAULT_VIBRATE)

        mNotificationManager!!.notify(REQUEST_ID, mBuilder.build())
    }

    companion object {

        fun getInstance(application: Application, context: Context): Firebase {
            return Firebase(application, context)
        }
    }

}
