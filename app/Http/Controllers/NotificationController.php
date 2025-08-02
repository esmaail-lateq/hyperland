<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the user's notifications.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = $user->notifications();
        
        // Filter by read status
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'unread':
                    $query->whereNull('read_at');
                    break;
                case 'read':
                    $query->whereNotNull('read_at');
                    break;
            }
        }
        
        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        
        $notifications = $query->latest()->paginate(20);
        
        return view('notifications.index', compact('notifications'));
    }
    
    /**
     * Mark a notification as read.
     */
    public function markAsRead(DatabaseNotification $notification)
    {
        // Ensure the notification belongs to the authenticated user
        if ($notification->notifiable_id !== Auth::id()) {
            abort(403);
        }
        
        $notification->markAsRead();
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('notifications.marked_as_read')
            ]);
        }
        
        return back()->with('success', __('notifications.marked_as_read'));
    }
    
    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('notifications.all_marked_as_read')
            ]);
        }
        
        return back()->with('success', __('notifications.all_marked_as_read'));
    }
    
    /**
     * Delete a notification.
     */
    public function destroy(DatabaseNotification $notification)
    {
        // Ensure the notification belongs to the authenticated user
        if ($notification->notifiable_id !== Auth::id()) {
            abort(403);
        }
        
        $notification->delete();
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('notifications.deleted')
            ]);
        }
        
        return back()->with('success', __('notifications.deleted'));
    }
    
    /**
     * Get unread notifications count (for AJAX).
     */
    public function getUnreadCount()
    {
        $count = Auth::user()->unreadNotifications()->count();
        
        return response()->json([
            'count' => $count,
            'formatted_count' => $count > 99 ? '99+' : $count
        ]);
    }
    
    /**
     * Get recent notifications (for dropdown).
     */
    public function getRecent()
    {
        $notifications = Auth::user()->getRecentNotifications(5);
        
        return response()->json([
            'notifications' => $notifications->map(function ($notification) {
                $data = $notification->data;
                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans(),
                    'message' => $data['message_ar'] ?? $data['message_en'] ?? $data['message'] ?? 'إشعار جديد'
                ];
            })
        ]);
    }
}
