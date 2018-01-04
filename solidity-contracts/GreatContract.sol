pragma solidity ^0.4.0;

contract GreatContract {
    address owner;
    uint public tokenPrice = 1 ether;
    uint public numberOfAllTokens;
    uint public numberOfAvailableTokens;
    uint public numberOfSoldTokens;
    mapping(address => uint) public purchasers;
    uint256 public accountBalance;

    function GreatContract(){
        owner = msg.sender;
        numberOfAllTokens = 12;
        numberOfAvailableTokens = numberOfAllTokens;
        numberOfSoldTokens = 0;
    }

    modifier OnlyOwner{
        require(msg.sender == owner);
        _;
    }

    function setAccountBalance() {
        accountBalance = msg.sender.balance;
    }

    function setTokenPrice(uint value) OnlyOwner {
        tokenPrice = value;
    }

    function setNumberOfAllTokens(uint value) OnlyOwner {
        numberOfAllTokens = value;
        numberOfAvailableTokens = numberOfAllTokens - numberOfSoldTokens;
    }

    function buyTokens(uint amount) payable {
        if (msg.value != (amount * tokenPrice) || amount > numberOfAvailableTokens) {
            throw;
        }

        purchasers[msg.sender] += amount;
        numberOfSoldTokens += amount;
        numberOfAvailableTokens -= amount;
    }
}
