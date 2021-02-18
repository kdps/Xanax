
object GrantUtility {

    // Check that granted of all permission list
    fun isGranted(context: Context, permissions: Array<String>): Boolean {
        var granted = true
        
        for (permission in permissions) {
            if (!this.isGranted(context, permission)) {
                granted = false
            }
        }

        return granted
    }
    
    // Check that granted of single permission
    fun isGranted(context: Context, permission: String): Boolean {
        if (Build.VERSION.SDK_INT >= 23) {
            return this.getGrantedStatus(context, permission) == PERMISSION_GRANTED
        }
        
        return true
    }

    // Get State Of Specify Grant
    fun getGrantedStatus(context: Context, permission: String): Int {
        return ContextCompat.checkSelfPermission(context, permission)
    }
    
}
