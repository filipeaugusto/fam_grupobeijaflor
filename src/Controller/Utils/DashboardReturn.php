<?php

namespace App\Controller\Utils;

class DashboardReturn
{
    protected float $input = 0;
    protected float $output = 0;
    protected float $result = 0;
    protected float $percentage = 0;
    protected float $waiting = 0;
    protected float $waiting_for_input = 0;
    protected float $waiting_for_output = 0;
    protected float $input_check = 0;

    protected bool $progress = true;

    /**
     * @param float $input
     * @param float $output
     */
    public function __construct(float $input, float $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this->result = $input - $output;

        try {
            if ($this->getInput() == 0) {
                throw new \DivisionByZeroError('Got exception by zero');
            }
            $this->setPercentage(($this->getInput() - $this->getResult()) / $this->getInput() * 100);
        } catch (\DivisionByZeroError $e) {
            $this->setPercentage($this->getOutput() > 0 ? 100 :  0);
        }

    }

    /**
     * @return float|int
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @param float|int $input
     * @return DashboardReturn
     */
    public function setInput($input): DashboardReturn
    {
        $this->input = $input;
        return $this;
    }

    /**
     * @return float|int
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param float|int $output
     * @return DashboardReturn
     */
    public function setOutput($output): DashboardReturn
    {
        $this->output = $output;
        return $this;
    }

    /**
     * @return float|int
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param float|int $result
     * @return DashboardReturn
     */
    public function setResult($result): DashboardReturn
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return float|int
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * @param float|int $percentage
     * @return DashboardReturn
     */
    public function setPercentage($percentage): DashboardReturn
    {
        $this->percentage = $percentage;
        return $this;
    }

    /**
     * @return float|int
     */
    public function getWaiting()
    {
        return $this->waiting;
    }

    /**
     * @param float|int $waiting
     * @return DashboardReturn
     */
    public function setWaiting($waiting): DashboardReturn
    {
        $this->waiting = $waiting;
        return $this;
    }

    /**
     * @return float|int
     */
    public function getWaitingForInput()
    {
        return $this->waiting_for_input;
    }

    /**
     * @param float|int $waiting_for_input
     * @return DashboardReturn
     */
    public function setWaitingForInput($waiting_for_input): DashboardReturn
    {
        $this->waiting_for_input = $waiting_for_input;
        return $this;
    }

    /**
     * @return float|int
     */
    public function getWaitingForOutput()
    {
        return $this->waiting_for_output;
    }

    /**
     * @param float|int $waiting_for_output
     * @return DashboardReturn
     */
    public function setWaitingForOutput($waiting_for_output): DashboardReturn
    {
        $this->waiting_for_output = $waiting_for_output;
        return $this;
    }

    /**
     * @return bool
     */
    public function isProgress(): bool
    {
        return $this->progress;
    }

    /**
     * @param bool $progress
     * @return DashboardReturn
     */
    public function setProgress(bool $progress): DashboardReturn
    {
        $this->progress = $progress;
        return $this;
    }

    /**
     * @return float|int
     */
    public function getInputCheck()
    {
        return $this->input_check;
    }

    /**
     * @param float|int $input_check
     * @return DashboardReturn
     */
    public function setInputCheck($input_check)
    {
        $this->input_check = $input_check;
        return $this;
    }

}
