<?php
/**
 * NOTICE OF LICENSE.
 *
 * UNIT3D is open-sourced software licensed under the GNU General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D
 *
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 * @author     HDVinnie, singularity43
 */

namespace App\Notifications;

use App\Torrent;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUploadTip extends Notification implements ShouldQueue
{
    use Queueable;

    public $type;
    public $tipper;
    public $torrent;
    public $amount;

    /**
     * Create a new notification instance.
     *
     * @param Torrent $torrent
     *
     * @return void
     */
    public function __construct(string $type, string $tipper, $amount, Torrent $torrent)
    {
        $this->type = $type;
        $this->tipper = $tipper;
        $this->torrent = $torrent;
        $this->amount = $amount;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        $appurl = config('app.url');

        return [
            'title' => $this->tipper.' Has Tipped You '.$this->amount.' BON For An Uploaded Torrent',
            'body'  => $this->tipper.' has tipped one of your Uploaded torrents: '.$this->torrent->name,
            'url'   => "/torrents/{$this->torrent->slug}.{$this->torrent->id}",
        ];
    }
}