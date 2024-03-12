<?php
/**
 * Users model
 *
 * @version 1.0
 * @author Onelab <hello@onelab.co>
 *
 */
class TaxProfilesModel extends DataList
{
	/**
	 * Initialize
	 */
	public function __construct()
	{
		$this->setQuery(DB::table(TABLE_PREFIX.TABLE_PROFILES));
	}

    public function search($search_query)
    {
        parent::search($search_query);
        $search_query = $this->getSearchQuery();

        if (!$search_query) {
            return $this;
        }

        $query = $this->getQuery();
        $search_strings = array_unique((explode(" ", $search_query)));
        foreach ($search_strings as $sq) {
            $sq = trim($sq);

            if (!$sq) {
                continue;
            }

            $query->where(function($q) use($sq) {
                $q->where(TABLE_PREFIX.TABLE_PROFILES.".id", "LIKE", $sq."%");
                $q->orWhere(TABLE_PREFIX.TABLE_PROFILES.".name", "LIKE", $sq."%");
            });
        }

        return $this;
    }

    public function fetchData()
    {
        $this->paginate();

        $this->getQuery()
             ->select(TABLE_PREFIX.TABLE_PROFILES.".*");
        $this->data = $this->getQuery()->get();
        return $this;
    }
}
